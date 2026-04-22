<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Task extends Model {
  public $id;          // int
  public $title;       // string
  public $description; // string
  public $createdAt;   // date
  public $startline;   // date
  public $deadline;    // date
  public $projectId;   // int

  public function columnMap(): array {
    return [
      'id'          => 'id',
      'title'       => 'title',
      'description' => 'description',
      'created_at'  => 'createdAt',
      'startline'   => 'startline',
      'deadline'    => 'deadline',
      'project_id'  => 'projectId',
    ];
  }

  public function initialize() {
    $this->setSource("tasks");
    $this->setSchema("public");
    $this->skipAttributesOnCreate(['id']);

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
