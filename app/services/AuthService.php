<?php
namespace App\Services;

use App\Dto\Request\CreateUserRequestDto;
use App\Library\UnauthorizedException;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IAuthService;

class AuthService implements IAuthService {
  public function __construct(
    private IUserRepository $userRepository,
    private \Phalcon\Encryption\Security $security,
    private \Phalcon\Session\Manager $session,
  ) {}

  public function authenticateUser(string $email, string $password): bool {
    $user = $this->userRepository->findByEmail($email);

    if (
      $user === null || ! $this->security->checkHash($password, $user->password)
    ) {throw new UnauthorizedException("Invalid credentials.");}

    $this->session->set('auth_user_id', $user->id);
    return true;
  }

  public function logout(): void {
    $this->session->remove('auth_user_id');
  }

  public function registerUser(CreateUserRequestDto $request): bool {
    if ($this->userRepository->findByEmail($request->email) !== null) {
      throw new \RuntimeException("Email already in use.");
    }

    $user           = User::fromRequest($request);
    $user->password = $this->security->hash($request->password);
    $save           = $this->userRepository->create($user);

    if ($save === false) {
      throw new \RuntimeException("Failed to create user");
    }

    return true;
  }
}