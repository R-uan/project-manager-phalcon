<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Repositories\Interfaces\IUserRepository;

class UserService {
  public function __construct(
    private IUserRepository $userRepository,
    private IMembershipRepository $membershipRepository,
  ) {}

  public function findUserById(int $id): ?User {
    return $this->userRepository->findById($id);
  }

  /** @return MembershipView[] */
  public function getMemberships(User $user) {
    return $this->membershipRepository->findUserMemberships($user->id);
  }
}