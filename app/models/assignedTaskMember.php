<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class AssignedTaskMember extends Model {
  public $id;               // int
  public $taskId;           // int
  public $assignedMemberId; // int

  public function columnMap(): array {
    return [
      'id'                 => 'id',
      'task_id'            => 'taskId',
      'assigned_member_id' => 'assignedMemberId',
      'created_at'         => 'createdAt',
    ];
  }

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