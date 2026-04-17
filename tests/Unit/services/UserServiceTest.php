<?php

// tests/Unit/UserServiceTest.php

use App\Dto\Request\AuthenticateUserRequestDto;
use App\Dto\Request\CreateUserRequestDto;
use App\Dto\Response\CreateUserResponseDto;
use App\Library\JwtService;
use App\Library\UnauthorizedException;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\UserService;
use Phalcon\Di\Di;
use Phalcon\Di\FactoryDefault;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase {
  private IUserRepository $userRepository;
  private JwtService $jwtService;
  private UserService $sut;

  protected function setUp(): void {
    $di = new FactoryDefault();
    Di::setDefault($di);

    $this->userRepository = $this->createMock(IUserRepository::class);
    $this->jwtService     = $this->createMock(JwtService::class);
    $this->sut            = new UserService($this->userRepository, $this->jwtService);
  }

  protected function tearDown(): void {
    Di::reset(); // Clean slate between tests
  }

  // ------------------------------------------------
  // createUser
  // ------------------------------------------------

  public function testCreateUserReturnsDto(): void {
    $request             = new CreateUserRequestDto();
    $request->email      = 'john@example.com';
    $request->first_name = 'John';
    $request->last_name  = 'Doe';
    $request->password   = 'secret123';

    // Email not taken
    $this->userRepository
      ->method('findByEmail')
      ->with('john@example.com')
      ->willReturn(null);

    // Save succeeds
    $this->userRepository
      ->method('create')
      ->willReturn(true);

    $response = $this->sut->createUser($request);

    $this->assertInstanceOf(CreateUserResponseDto::class, $response);
    $this->assertEquals('john@example.com', $response->email);
    $this->assertEquals('John', $response->firstName);
  }

  public function testCreateUserThrowsWhenEmailAlreadyInUse(): void {
    $request        = new CreateUserRequestDto();
    $request->email = 'john@example.com';

    // Simulate existing user
    $this->userRepository
      ->method('findByEmail')
      ->willReturn(new User());

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Email already in use: john@example.com');

    $this->sut->createUser($request);
  }

  public function testCreateUserThrowsWhenRepositoryFails(): void {
    $request             = new CreateUserRequestDto();
    $request->email      = 'john@example.com';
    $request->first_name = "john";
    $request->last_name  = "pork";
    $request->password   = 'secret123';

    $this->userRepository->method('findByEmail')->willReturn(null);
    $this->userRepository->method('create')->willReturn(false); // DB fails

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Failed to create user');

    $this->sut->createUser($request);
  }

  public function testCreateUserNeverCallsCreateWhenEmailIsTaken(): void {
    $request        = new CreateUserRequestDto();
    $request->email = 'john@example.com';

    $this->userRepository->method('findByEmail')->willReturn(new User());

    // Equivalent to: mockRepo.Verify(x => x.create(...), Times.Never)
    $this->userRepository
      ->expects($this->never())
      ->method('create');

    try {
      $this->sut->createUser($request);
    } catch (\RuntimeException) {}
  }

  // ------------------------------------------------
  // authenticateUser
  // ------------------------------------------------

  public function testAuthenticateUserReturnsToken(): void {
    $request           = new AuthenticateUserRequestDto();
    $request->email    = 'john@example.com';
    $request->password = 'secret123';

    $user           = new User();
    $user->email    = 'john@example.com';
    $user->password = password_hash('secret123', PASSWORD_BCRYPT);

    $this->userRepository
      ->method('findByEmail')
      ->willReturn($user);

    $this->jwtService
      ->method('encode')
      ->with($user)
      ->willReturn('mocked.jwt.token');

    $token = $this->sut->authenticateUser($request);

    $this->assertEquals('mocked.jwt.token', $token);
  }

  public function testAuthenticateUserThrowsWhenUserNotFound(): void {
    $request        = new AuthenticateUserRequestDto();
    $request->email = 'ghost@example.com';

    $this->userRepository->method('findByEmail')->willReturn(null);

    $this->expectException(UnauthorizedException::class);
    $this->expectExceptionMessage('Invalid credentials');

    $this->sut->authenticateUser($request);
  }

  public function testAuthenticateUserThrowsOnWrongPassword(): void {
    $request           = new AuthenticateUserRequestDto();
    $request->email    = 'john@example.com';
    $request->password = 'wrongpassword';

    $user           = new User();
    $user->password = password_hash('secret123', PASSWORD_BCRYPT); // correct hash

    $this->userRepository->method('findByEmail')->willReturn($user);

    $this->expectException(UnauthorizedException::class);

    $this->sut->authenticateUser($request);
  }

  public function testAuthenticateUserNeverCallsJwtWhenCredentialsInvalid(): void {
    $request           = new AuthenticateUserRequestDto();
    $request->email    = 'john@example.com';
    $request->password = 'wrong';

    $user           = new User();
    $user->password = password_hash('secret123', PASSWORD_BCRYPT);

    $this->userRepository->method('findByEmail')->willReturn($user);

    $this->jwtService
      ->expects($this->never())
      ->method('encode');

    try {
      $this->sut->authenticateUser($request);
    } catch (UnauthorizedException) {}
  }
}