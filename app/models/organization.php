<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class Organization extends Model {
  public $id;
  public $name;
  public $created_at;

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("organizations");

    $this->hasMany(
      'id',
      Membership::class,
      'organization_id',
      [
        'alias'    => 'memberships',
        'reusable' => true,
      ]
    );

    $this->hasMany(
      "id",
      OrganizationContact::class,
      "organization_id",
      [
        "alias" => "contact",
      ]
    );

    $this->hasMany(
      "id",
      Project::class,
      "organization_id",
      [
        "alias"    => "projects",
        "reusable" => true,
      ]
    );
  }
}