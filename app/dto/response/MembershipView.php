<?php
namespace App\Dto\Response;

class MembershipView {
  public function __construct(
    public $userId,
    public $userFirstName,
    public $userLastName,
    public $orgId,
    public $role,
    public $orgName,
  ) {}

  public static function fromArray(mixed $membership) {
    return new MembershipView(
      $membership['userId'],
      $membership["firstName"],
      $membership['lastName'],
      $membership['orgId'],
      $membership["role"],
      $membership['orgName'],
    );
  }
}