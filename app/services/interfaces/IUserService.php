<?php
namespace App\Services\Interfaces;

use App\Models\User;

interface IUserService {
  public function createUser(User $user): bool;
  public function findUserById(int $userId): ?User;
  public function findUserByEmail(string $userEmail): ?User;
  public function findUserByUsername(string $username): ?User;
  public function checkUniqueAvailability(string $field, string $value): bool;
}