<?php
namespace App\Dto\Request;

class CreateUserRequestDto {
  public string $email;
  public string $firstName;
  public string $lastName;
  public string $password;
}