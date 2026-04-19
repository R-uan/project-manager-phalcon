<?php
namespace App\Repositories\Interfaces;

use App\Models\Membership;

interface IMembershipRepository {
  public function save(Membership $membership): bool;
  public function findUserMemberships(int $userId): array;
  public function findMembership(int $org_id, int $user_id): ?Membership;
}