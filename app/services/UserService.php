<?php
namespace App\Services;

use App\Dto\Response\ProfileView;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IMembershipService;
use App\Services\Interfaces\IUserService;

class UserService implements IUserService {
  public function __construct(
    private IUserRepository $userRepository,
    private IMembershipService $membershipService,
  ) {}

  public function createUser(User $user): bool {
    return $this->userRepository->create($user);
  }

  public function findUserById(int $id): ?User {
    return $this->userRepository->findById($id);
  }

  public function findUserByEmail(string $userEmail): ?User {
    return $this->userRepository->findByEmail($userEmail);
  }

  public function findUserByUsername(string $username): ?User {
    return $this->userRepository->findByUsername($username);
  }

  public function getUserProfile(string $username): ?ProfileView {
    $user = $this->findUserByUsername($username) ??
    throw new \Exception("User was not found.");
    $userMemberships = $this->membershipService->findUserMemberships($user->id);
    return ProfileView::from($user, $userMemberships);
  }

  public function checkUniqueAvailability(string $field, string $value): bool {
    $user = match ($field) {
      'username' => $this->userRepository->findByUsername($value),
      'email'    => $this->userRepository->findByEmail($value),
      default    => null
    };

    if ($user === null) {return true;}
    return false;
  }
}