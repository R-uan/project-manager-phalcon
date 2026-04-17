<?php
namespace App\Repositories;

use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Repositories\Interfaces\IOrganizationRepository;
use Phalcon\Mvc\Model\ResultsetInterface;

class OrganizationRepository implements IOrganizationRepository {

  public function __construct(
    private MembershipRepository $membershipRepository,
  ) {}

  public function create(Organization $org): bool {
    return $org->save();
  }

  public function findAll(): ResultsetInterface {
    return Organization::find([
      'order' => 'name ASC',
    ]);
  }

  public function findById(int $id): ?Organization {
    /** @var Organization|null */
    return Organization::findFirst([
      'condition' => 'id :id:',
      'bind'      => ['id', $id],
    ]);
  }

  public function addMember(User $user, Organization $org): bool {
    $membership = $this->membershipRepository->findMembership($org->id, $user->id);
    if ($membership !== null) {throw new \Exception("Already a member");}
    $new_membership = new Membership($user->id, $org->id, "MEMBER");
    return $new_membership->save();
  }

  public function removeMember(User $user, Organization $org): bool {
    $membership = $this->membershipRepository->findMembership($org->id, $user->id);
    if ($membership === null) {throw new \Exception("Not a member");}
    return $membership->delete();
  }
}