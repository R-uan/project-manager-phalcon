<?php
namespace App\Dto\Response;

class MembershipView {
  public function __construct(
    public int $userId,
    public int $orgId,
    public string $role,
    public string $orgName,
    public string $orgEmail,
    public ?string $orgWebsite,
  ) {}
}