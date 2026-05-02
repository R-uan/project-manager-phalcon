<?php
namespace App\Services;

use App\Dto\Response\MembershipView;
use App\Models\Membership;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Services\Interfaces\IMembershipService;

class MembershipService implements IMembershipService {
  public function __construct(
    private IMembershipRepository $membershipRepository,
  ) {}

  public function createMembership(Membership $membership): bool {
    $exists = $this->membershipRepository->findMembership($membership->orgId, $membership->userId);
    if (isset($exists) === true) {throw new \Exception("User is already a memeber.");}
    return $this->membershipRepository->save($membership);
  }

  public function deleteMembership(int $orgId, int $userId): bool {
    return $this->membershipRepository->delete($orgId, $userId);
  }

  public function findUserMemberships(int $userId): array {
    return $this->membershipRepository->findUserMemberships($userId);
  }

  /** @return MembershipView[] */
  public function findOrganizationMemberships(int $userId, int $orgId): array {
    if ($this->findMembership($orgId, $userId) === null) {
      throw new \Exception("You are not a member of this organization.");
    }

    return $this->membershipRepository->findOrganizationMemberships($orgId);
  }

  public function findMembership(int $orgId, int $userId): ?MembershipView {
    return $this->membershipRepository->findMembership($orgId, $userId);
  }
}