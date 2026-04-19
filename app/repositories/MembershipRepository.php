<?php
namespace App\Repositories;

use App\Dto\Response\MembershipView;
use App\Models\Membership;
use App\Repositories\Interfaces\IMembershipRepository;

class MembershipRepository implements IMembershipRepository {
  public function __construct(
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function save(Membership $membership): bool {
    return $membership->save();
  }

  public function findMembership(int $org_id, int $user_id): ?Membership {
    /** @var Membership|null */
    return Membership::findFirst([
      'conditions' => 'user_id = :user_id: AND organization_id = :org_id:',
      'bind'       => [
        'user_id' => $user_id,
        'org_id'  => $org_id,
      ],
    ]);
  }

  /**
   * @return MembershipView[]
   */
  public function findUserMemberships(int $userId): array {
    $memberships = $this->modelsManager->createQuery('
      SELECT
        m.role, m.user_id,
        o.id AS org_id, o.name AS org_name,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\Organization o ON o.id = m.organization_id
      LEFT JOIN App\Models\OrganizationContact oc ON oc.organization_id = o.id
      WHERE m.user_id = :userId:
    ')->execute(['userId' => $userId]);

    return array_map(function ($row) {
      return new MembershipView(
        userId: $row->user_id,
        orgId: $row->org_id,
        role: $row->role,
        orgName: $row->org_name,
        orgEmail: $row->email,
        orgWebsite: $row->website,
      );
    }, iterator_to_array($memberships));
  }
}