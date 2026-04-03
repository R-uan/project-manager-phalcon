<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class AssignedProjectMember extends Model {
  public $id;            // int
  public $project_id;    // int
  public $membership_id; // int

  public function initialize() {
    $this->setSchema("public");
    $this->setSource("assigned_project_members");

    $this->belongsTo(
      "membership_id",
      Membership::class,
      "id",
    );

    $this->belongsTo(
      "project_id",
      Project::class,
      "id",
    );
  }
}