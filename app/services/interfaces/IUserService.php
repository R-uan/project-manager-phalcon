<?php
namespace App\Services\Interfaces;

use App\Models\User;

interface IUserService {
  public function findUserById(int $userId): ?User;
  public function findUserByEmail(string $userEmail): ?User;
}