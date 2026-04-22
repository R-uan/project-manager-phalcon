<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class AssignedProjectMember extends Model {
  public $id;           // int
  public $projectId;    // int
  public $membershipId; // int
  public $createdAt;

  public function columnMap(): array {
    return [
      'id'            => 'id',
      'project_id'    => 'projectId',
      'membership_id' => 'membershipId',
      'created_at'    => 'createdAt',
    ];
  }

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