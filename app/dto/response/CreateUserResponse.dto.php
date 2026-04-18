<?php
namespace App\Dto\Response;

use App\Models\User;

class CreateUserResponseDto {
  public $id;
  public $firstName;
  public $lastName;
  public $email;

  public static function fromEntity(User $user) {
    $dto            = new CreateUserResponseDto();
    $dto->id        = $user->id;
    $dto->firstName = $user->first_name;
    $dto->lastName  = $user->last_name;
    $dto->email     = $user->email;
    return $dto;
  }
}