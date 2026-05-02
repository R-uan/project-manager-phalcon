<?php
namespace App\Dto\Request;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;

class CreateOrganizationRequestDto {
  public string $displayName;
  public string $orgHandle;
  public string $contactEmail;
  public bool $isPublic;

  public static function fromArray(array $data): self {
    $dto               = new self();
    $dto->displayName  = $data["displayName"];
    $dto->orgHandle    = $data["handle"];
    $dto->contactEmail = $data['contactEmail'];
    $dto->isPublic     = $data['isPublic'] === '1';
    return $dto;
  }

  public function validate(): array | true {
    $v = new Validation();

    $v->add('contactEmail', new Email(['message' => 'Invalid contact email.']));
    $v->add('orgHandle', new PresenceOf(['message' => 'Organization handle is required.']));
    $v->add('displayName', new PresenceOf(['message' => 'Organization display name is required.']));

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