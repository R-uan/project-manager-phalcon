<?php
namespace App\Services;

use App\Dto\Request\CreateUserRequestDto;
use App\Library\UnauthorizedException;
use App\Models\User;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IUserService;

class AuthService implements IAuthService {
  public function __construct(
    private IUserService $userService,
    private \Phalcon\Encryption\Security $security,
    private \Phalcon\Session\Manager $session,
  ) {}

  public function authenticateUser(string $email, string $password): array {
    $user = $this->userService->findUserByEmail($email);

    if (
      $user === null ||
      $this->security->checkHash($password, $user->password) === false
    ) {
      throw new UnauthorizedException("Invalid credentials.");
    }

    return [
      'userId'   => $user->id,
      'username' => $user->username,
    ];
  }

  public function logout(): void {
  }

  public function registerUser(CreateUserRequestDto $request): bool {
    if ($this->userService->findUserByEmail($request->email) !== null) {
      throw new \RuntimeException("Email already in use.");
    }

    $user           = User::fromRequest($request);
    $user->password = $this->security->hash($request->password);
    $save           = $this->userService->createUser($user);

    if ($save === false) {
      throw new \RuntimeException("Failed to create user");
    }

    return true;
  }
}