<?php
namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Phalcon\Mvc\Model\ResultsetInterface;

class UserRepository implements IUserRepository {
  public function create(User $user): bool {
    return $user->save();
  }

  public function findById(int $id): ?User {
    /** @var User|null */
    return User::findFirst([
      'condition' => 'id = :id:',
      'bind'      => ['id' => $id],
    ]) ?: null;
  }

  public function findAll(): ResultsetInterface {
    return User::find([
      'order' => 'name ASC',
    ]);
  }

  public function findByEmail(string $email): ?User {
    /** @var User|null */
    return User::findFirst([
      'conditions' => 'email = :email:',
      'bind'       => ['email' => $email],
    ]) ?: null;
  }
}