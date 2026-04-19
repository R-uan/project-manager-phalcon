<?php

use App\Repositories\Interfaces\IMembershipRepository;

class MembershipService implements IMembershipService {
  public function __construct(
    private IMembershipRepository $membershipRepository
  ) {}

  public function findUserMemberships(int $userId) {
    return $this->membershipRepository->findUserMemberships($userId);
  }
}