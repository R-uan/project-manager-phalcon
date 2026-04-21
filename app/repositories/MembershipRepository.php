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

  public function findMembership(int $orgId, int $userId): ?MembershipView {
    /** @return Membership|null */
    $result = $this->modelsManager->createQuery('
      SELECT
        m.role, m.user_id,
        u.first_name, u.last_name,
        o.id AS org_id, o.name AS org_name,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.user_id
      LEFT JOIN App\Models\Organization o ON o.id = m.organization_id
      LEFT JOIN App\Models\OrganizationContact oc ON oc.organization_id = o.id
      WHERE m.user_id = :userId: AND m.organization_id = :orgId:
    ')->execute(['userId' => $userId, 'orgId' => $orgId])->getFirst();
    return $result !== null ? MembershipView::fromArray($result) : null;
  }

  /**
   * @return MembershipView[]
   */
  public function findUserMemberships(int $userId): array {
    $memberships = $this->modelsManager->createQuery('
      SELECT
        m.role, m.user_id,
        u.first_name, u.last_name,
        o.id AS org_id, o.name AS org_name,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.user_id
      LEFT JOIN App\Models\Organization o ON o.id = m.organization_id
      LEFT JOIN App\Models\OrganizationContact oc ON oc.organization_id = o.id
      WHERE m.user_id = :userId:
    ')->execute(['userId' => $userId]);

    return array_map(function ($row) {
      return MembershipView::fromArray($row);
    }, iterator_to_array($memberships));
  }

  /** @return MembershipView[] */
  public function findOrganizationMembers(int $orgId): array {
    $memberships = $this->modelsManager->createQuery('
      SELECT
        m.role, m.user_id,
        u.first_name, u.last_name,
        o.id AS org_id, o.name AS org_name,
        oc.website, oc.email
      FROM App\Models\Membership m
      LEFT JOIN App\Models\User u ON u.id = m.user_id
      LEFT JOIN App\Models\Organization o ON o.id = m.organization_id
      LEFT JOIN App\Models\OrganizationContact oc ON oc.organization_id = o.id
      WHERE m.organization_id = :orgId:
    ')->execute(['orgId' => $orgId]);

    return array_map(function ($row) {
      return MembershipView::fromArray($row);
    }, iterator_to_array($memberships));
  }
}