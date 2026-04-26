<?php
namespace App\Dto\Response;

use App\Models\User;

class ProfileView {
  public function __construct(
    public int $userId,
    public string $email,
    public string $firstName,
    public string $lastName,
    public ?string $location,
    public ?string $website,
    /** @var MembershipView[] */
    public array $memberships
  ) {}

  /**
   * @param MembershipView[] $memberships
   */
  public static function from(User $user, array $memberships) {
    return new ProfileView(
      $user->id,
      $user->email,
      $user->firstName,
      $user->lastName,
      $user->location,
      $user->website,
      $memberships
    );
  }
}