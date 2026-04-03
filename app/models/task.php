<?php
namespace App\Models;
use Plalcon\Mvc\Model;

class Task extends Model {
  public $id;          // number
  public $title;       // string
  public $description; // string
  public $created_at;  // date
  public $startline;   // date
  public $deadline;    // date
  public $project_id;

  public function initialize() {
    $this->setSource("project_tasks");
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