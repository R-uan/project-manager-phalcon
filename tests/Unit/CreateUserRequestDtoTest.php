<?php
namespace Tests\Unit;

use App\Dto\Request\CreateUserRequestDto;
use PHPUnit\Framework\TestCase;

class CreateUserRequestDtoTest extends TestCase {
  private function makeValid(): array {
    return [
      'email'     => 'john@example.com',
      'firstName' => 'John',
      'lastName'  => 'Doe',
      'password'  => 'secret1234',
    ];
  }

  private function makeDto(array $overrides = []): CreateUserRequestDto {
    return CreateUserRequestDto::fromArray(array_merge($this->makeValid(), $overrides));
  }

  public function testFromArrayMapsFieldsCorrectly(): void {
    $dto = $this->makeDto([
      'email'     => 'nihao@gmail.com',
      'firstName' => 'Liu',
      'lastName'  => 'Qi',
      'password'  => 'sup&rV4l!dP@ssw0rd',
    ]);

    $this->assertEquals('nihao@gmail.com', $dto->email);
    $this->assertEquals('Liu', $dto->first_name);
    $this->assertEquals('Qi', $dto->last_name);
    $this->assertEquals('sup&rV4l!dP@ssw0rd', $dto->password);
  }

  public function testValidDataPassesValidation(): void {
    $result = $this->makeDto()->validate();

    $this->assertTrue($result);
  }

  public function testInvalidEmailFails(): void {
    $result = $this->makeDto(['email' => 'not-an-email'])->validate();

    $this->assertIsArray($result);
    $this->assertContains('Invalid email', $result);
  }

  public function testEmptyEmailFails(): void {
    $result = $this->makeDto(['email' => ''])->validate();

    $this->assertIsArray($result);
  }

  public function testMissingFirstNameFails(): void {
    $result = $this->makeDto(['firstName' => ''])->validate();

    $this->assertIsArray($result);
    $this->assertContains('First name is required.', $result);
  }

  public function testMissingLastNameFails(): void {
    $result = $this->makeDto(['lastName' => ''])->validate();

    $this->assertIsArray($result);
    $this->assertContains('Last name is required.', $result);
  }

  public function testPasswordTooShortFails(): void {
    $result = $this->makeDto(['password' => 'short'])->validate();

    $this->assertIsArray($result);
    $this->assertContains("We don't want really small passwords", $result);
  }

  public function testPasswordAtMinBoundaryFails(): void {
    $result = $this->makeDto(['password' => '1234567'])->validate();

    $this->assertIsArray($result);
    $this->assertContains("We don't want really small passwords", $result);
  }

  public function testPasswordAboveMinBoundaryPasses(): void {
    $result = $this->makeDto(['password' => '123456789'])->validate();

    $this->assertTrue($result);
  }

  public function testPasswordAtMaxBoundaryPasses(): void {
    $result = $this->makeDto(['password' => str_repeat('a', 24)])->validate();

    $this->assertTrue($result);
  }

  public function testPasswordTooLongFails(): void {
    $result = $this->makeDto(['password' => str_repeat('a', 25)])->validate();

    $this->assertIsArray($result);
    $this->assertContains("We don't like really long passwords", $result);
  }

  public function testMultipleInvalidFieldsReturnsAllErrors(): void {
    $result = $this->makeDto([
      'email'     => 'bad-email',
      'firstName' => '',
      'lastName'  => '',
    ])->validate();

    $this->assertIsArray($result);
    $this->assertCount(3, $result);
  }
}