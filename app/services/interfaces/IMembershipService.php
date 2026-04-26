<?php
namespace App\Services\Interfaces;

use App\Dto\Response\MembershipView;
use App\Models\Membership;

interface IMembershipService {
  public function findUserMemberships(int $userId): array;
  public function findOrganizationMemberships(int $orgId): array;
  public function findMembership(int $orgId, int $userId): ?MembershipView;

  public function createMembership(Membership $membership);
  public function deleteMembership(int $orgId, int $userId): bool;
}