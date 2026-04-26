<?php
namespace App\Repositories\Interfaces;

use App\Dto\Response\MembershipView;
use App\Models\Membership;

interface IMembershipRepository {
  public function save(Membership $membership): bool;
  public function delete(int $orgId, int $userId): bool;
  public function findUserMemberships(int $userId): array;
  public function findOrganizationMemberships(int $orgId): array;
  public function findMembership(int $orgId, int $userId): ?MembershipView;
}