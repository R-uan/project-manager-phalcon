<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Membership extends Model {
  public $id;
  public $user_id;
  public $role;
  public $organization_id;

  public static function from(int $userId, int $organizationId, string $role): self {
    $membership                  = new self();
    $membership->user_id         = $userId;
    $membership->role            = $role;
    $membership->organization_id = $organizationId;
    return $membership;
  }

  public function initialize() {
    $this->setSchema("public");
    $this->setSource("memberships");
    $this->skipAttributesOnCreate(['id']);

    // User that is member
    $this->belongsTo(
      "user_id",
      User::class,
      "id",
      [
        'alias' => 'user',
      ]
    );

    // Organization it's member of
    $this->belongsTo(
      "organization_id",
      Organization::class,
      "id",
      [
        "alias" => "organization",
      ]
    );

    // JoinTable: Membership -> Project
    $this->hasManyToMany(
      "id",
      AssignedProjectMember::class,
      "membership_id",
      "project_id",
      Project::class,
      "id"
    );
  }
}