<?php
namespace App\Dto\Request;

class AuthenticateUserRequestDto {
  public string $email;
  public string $password;
}