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

  public function delete(int $orgId, int $userId): bool {
    $membership = Membership::findFirst([
      'conditions' => 'orgId = :orgId: AND userId = :userId:',
      'bind'       => [
        'orgId'  => $orgId,
        'userId' => $userId,
      ],
    ]);

    if (isset($membership) === false) {
      throw new \Exception("User membership not found.");
    }

    return $membership->delete();
  }

  /** @return MembershipView[] */
  public function findMembership(int $orgId, int $userId): ?MembershipView {
    $result = $this->modelsManager->createQuery('
      SELECT
        m.role, m.userId,
        u.firstName, u.lastName,
        o.id AS orgId, o.name AS orgName,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.userId
      LEFT JOIN App\Models\Organization o ON o.id = m.orgId
      LEFT JOIN App\Models\OrganizationContact oc ON oc.orgId = o.id
      WHERE m.userId = :userId: AND m.orgId = :orgId:
    ')->execute(['userId' => $userId, 'orgId' => $orgId])->getFirst();
    return $result !== null ? MembershipView::fromArray($result) : null;
  }

  /** @return MembershipView[] */
  public function findUserMemberships(int $userId): array {
    $memberships = $this->modelsManager->createQuery('
      SELECT
        m.role, m.userId,
        u.firstName, u.lastName,
        o.id AS orgId, o.name AS orgName,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.userId
      LEFT JOIN App\Models\Organization o ON o.id = m.orgId
      LEFT JOIN App\Models\OrganizationContact oc ON oc.orgId = o.id
      WHERE m.userId = :userId:
    ')->execute(['userId' => $userId]);

    return array_map(function ($row) {
      return MembershipView::fromArray($row);
    }, iterator_to_array($memberships));
  }

  /** @return MembershipView[] */
  public function findOrganizationMemberships(int $orgId): array {
    $memberships = $this->modelsManager->createQuery('
      SELECT
        m.role, m.userId,
        u.firstName, u.lastName,
        o.id AS orgId, o.name AS orgName,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.userId
      LEFT JOIN App\Models\Organization o ON o.id = m.orgId
      LEFT JOIN App\Models\OrganizationContact oc ON oc.orgId = o.id
      WHERE m.orgId = :orgId:
    ')->execute(['orgId' => $orgId]);

    return array_map(function ($row) {
      return MembershipView::fromArray($row);
    }, iterator_to_array($memberships));
  }
}