<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Membership extends Model {
  public $id;
  public $role;
  public $userId;
  public $createdAt;
  public $orgId;

  public static function from(int $userId, int $orgId, string $role): self {
    $membership         = new self();
    $membership->userId = $userId;
    $membership->role   = $role;
    $membership->orgId  = $orgId;
    return $membership;
  }

  public function columnMap(): array {
    return [
      'id'              => 'id',
      'role'            => 'role',
      'user_id'         => 'userId',
      'created_at'      => 'createdAt',
      'organization_id' => 'orgId',
    ];
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