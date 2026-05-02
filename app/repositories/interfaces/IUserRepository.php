<?php
namespace App\Repositories\Interfaces;

use App\Models\User;
use Phalcon\Mvc\Model\ResultsetInterface;

interface IUserRepository {
  public function create(User $user): bool;
  public function findById(int $id): ?User;
  public function findAll(): ResultsetInterface;
  public function findByEmail(string $email): ?User;
  public function findByUsername(string $username): ?User;
}