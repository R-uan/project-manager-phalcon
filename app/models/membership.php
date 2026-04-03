<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Membership extends Model {
  public $id;      // int
  public $role;    // string
  public $user_id; // foreign key
  public $organization_id;

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