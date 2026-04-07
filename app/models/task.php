<?php
namespace App\Models;
use Plalcon\Mvc\Model;

class Task extends Model {
  public $id;          // int
  public $title;       // string
  public $description; // string
  public $created_at;  // date
  public $startline;   // date
  public $deadline;    // date
  public $project_id;  // int

  public function initialize() {
    $this->setSource("tasks");
    $this->setSchema("public");

    $this->belongsTo(
      "project_id",
      Project::class,
      "id"
    );

    $this->hasManyToMany(
      "id",
      AssignedTaskMember::class,
      "task_id",
      "assigned_member_id",
      AssignedProjectMember::class,
      "id" // Should this move directly to membership ?
    );
  }
}
