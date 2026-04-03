<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Project extends Model {
  public $id;              // int
  public $name;            // string
  public $description;     // string
  public $organization_id; // int

  public $deadline;  // date | null
  public $startline; // date

  public $created_at; // date
  public $updated_at; // date

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("projects");

    $this->belongsTo(
      "organization_id",
      Organization::class,
      "id"
    );

    $this->hasManyToMany(
      "id",
      AssignedProjectMember::class,
      "project_id",
      "membership_id",
      Membership::class,
      "id"
    );

    $this->hasMany(
      "id",
      Task::class,
      "project_id",
      [
        "alias" => "tasks",
      ]
    );
  }
}