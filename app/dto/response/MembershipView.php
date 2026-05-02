<?php
namespace App\Dto\Response;

class MembershipView {
  public function __construct(
    public $userId,
    public $role,
    public $userFirstName,
    public $userLastName,

    public $orgId,
    public $orgDisplayName,
    public $orgHandle,
    public $isPublic,
  ) {}

  public static function fromArray(mixed $membership) {
    return new MembershipView(
      userId: $membership['userId'],
      userFirstName: $membership["firstName"],
      userLastName: $membership['lastName'],
      orgId: $membership['orgId'],
      role: $membership["role"],
      orgHandle: $membership['orgHandle'],
      isPublic: $membership['isPublic'],
      orgDisplayName: $membership['displayName']
    );
  }
}