<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Membership extends Model {
  public $id; // int

  public function __construct(
    public int $user_id,
    public int $organization_id,
    public $role, // string
  ) {}

  public function initialize() {
    $this->setSchema("public");
    $this->setSource("memberships");

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