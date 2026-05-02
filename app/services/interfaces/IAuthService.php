<?php
namespace App\Services\Interfaces;
use App\Dto\Request\CreateUserRequestDto;

interface IAuthService {
  public function logout(): void;
  public function registerUser(CreateUserRequestDto $request): bool;
  public function authenticateUser(string $email, string $password): array;
}