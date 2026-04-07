<?php
namespace App\Services;

use App\Dto\Request\AuthenticateUserRequestDto;
use App\Dto\Request\CreateUserRequestDto;
use App\Dto\Response\CreateUserResponseDto;
use App\Library\JwtService;
use App\Library\UnauthorizedException;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserService {
  public function __construct(
    private IUserRepository $userRepository,
    private JwtService $jwtService
  ) {}

  public function createUser(CreateUserRequestDto $request): CreateUserResponseDto {
    if ($this->userRepository->findByEmail($request->email)) {
      throw new \RuntimeException("Email already in use: {$request->email}");
    }

    $user             = new User();
    $user->email      = $request->email;
    $user->first_name = $request->firstName;
    $user->last_name  = $request->lastName;
    $user->password   = password_hash($request->password, PASSWORD_BCRYPT);
    $save             = $this->userRepository->create($user);

    if ($save === false) {
      throw new \RuntimeException("Failed to create user");
    }

    return CreateUserResponseDto::fromEntity($user);
  }

  public function authenticateUser(AuthenticateUserRequestDto $request): ?string {
    $user = $this->userRepository->findByEmail($request->email);

    if (
      $user === null ||
      password_verify($request->password, $user->password) === false
    ) {
      throw new UnauthorizedException("Invalid credentials");
    }

    return $this->jwtService->encode($user);
  }

  public function test() {
    $user        = new User();
    $user->id    = 999;
    $user->email = "test";
    return $this->jwtService->encode($user);
  }
}