<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class AssignedTaskMember extends Model {
  public $id;                 // int
  public $task_id;            // int
  public $assigned_member_id; // int

  public function initialize() {
    $this->setSource("assigned_task_members");
    $this->setSchema("public");

    $this->belongsTo(
      "assigned_member_id",
      AssignedProjectMember::class,
      "id",
    );

    $this->belongsTo(
      'task_id',
      Task::class,
      'id'
    );
  }
}