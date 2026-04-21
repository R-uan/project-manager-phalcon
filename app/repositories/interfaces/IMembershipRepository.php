<?php
namespace App\Repositories\Interfaces;

use App\Dto\Response\MembershipView;
use App\Models\Membership;

interface IMembershipRepository {
  public function save(Membership $membership): bool;
  /** @return MembershipView[] */
  public function findUserMemberships(int $userId): array;
  /** @return MembershipView[] */
  public function findOrganizationMembers(int $orgId): array;
  public function findMembership(int $orgId, int $userId): ?MembershipView;
}