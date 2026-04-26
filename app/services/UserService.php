<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;

class UserService implements IUserService {
  public function __construct(
    private IUserRepository $userRepository,
  ) {}

  public function findUserById(int $id): ?User {
    return $this->userRepository->findById($id);
  }

  public function findUserByEmail(string $userEmail): ?User {
    return $this->userRepository->findByEmail($userEmail);
  }
}