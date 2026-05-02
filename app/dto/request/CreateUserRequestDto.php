<?php
namespace App\Dto\Request;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength;

class CreateUserRequestDto {
  public string $email;
  public string $username;
  public string $first_name;
  public string $last_name;
  public string $password;

  public static function fromArray(array $data): CreateUserRequestDto {
    $dto             = new self();
    $dto->email      = $data["email"];
    $dto->username   = $data['username'];
    $dto->first_name = $data['firstName'];
    $dto->last_name  = $data['lastName'];
    $dto->password   = $data['password'];
    return $dto;
  }

  public function validate(): array | true {
    $v = new Validation();

    $v->add('email', new Email(['message' => 'Invalid email']));

    $v->add('first_name', new PresenceOf(['message' => 'First name is required.']));
    $v->add('first_name', new StringLength([
      'min'            => 2,
      'max'            => 50,
      'messageMinimum' => 'First name must be at least 2 characters.',
      'messageMaximum' => 'First name cannot exceed 50 characters.',
    ]));

    $v->add('username', new PresenceOf(['message' => 'Username is required.']));
    $v->add('username', new StringLength([
      'min'            => 3,
      'max'            => 30,
      'messageMinimum' => 'Username must be at least 3 characters.',
      'messageMaximum' => 'Username cannot exceed 30 characters.',
    ]));

    $v->add('last_name', new PresenceOf(['message' => 'Last name is required.']));
    $v->add('last_name', new StringLength([
      'min'            => 2,
      'max'            => 50,
      'messageMinimum' => 'Last name must be at least 2 characters.',
      'messageMaximum' => 'Last name cannot exceed 50 characters.',
    ]));

    $v->add('password', new StringLength([
      "min"             => 8,
      "max"             => 24,
      "messageMaximum"  => "We don't like really long passwords",
      "messageMinimum"  => "We don't want really small passwords",
      "includedMaximum" => false,
      "includedMinimum" => false,
    ]));

    $messages = $v->validate((array)$this);

    if (\count($messages)) {
      $errors = [];
      foreach ($messages as $msg) {
        $errors[] = $msg->getMessage();
      }
      return $errors;
    }

    return true;
  }
}