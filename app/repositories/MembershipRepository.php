<?php
namespace App\Repositories;

use App\Models\Membership;
use App\Repositories\Interfaces\IMembershipRepository;

class MembershipRepository implements IMembershipRepository {
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
}