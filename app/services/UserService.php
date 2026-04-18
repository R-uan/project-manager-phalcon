<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserService {
  public function __construct(
    private IUserRepository $userRepository,
  ) {}

  public function findUserById(int $id): ?User {
    return $this->userRepository->findById($id);
  }
}