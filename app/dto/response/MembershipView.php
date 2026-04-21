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
      $membership['user_id'],
      $membership["first_name"],
      $membership['last_name'],
      $membership['org_id'],
      $membership["role"],
      $membership['org_name'],
    );
  }
}