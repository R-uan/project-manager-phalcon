<?php
namespace App\Models;

use App\Dto\Request\CreateOrganizationRequestDto;
use Phalcon\Mvc\Model;

class Organization extends Model {
  public $id;
  public $name;
  public $location;
  public $isPublic;
  public $createdAt;

  public static function fromRequest(CreateOrganizationRequestDto $request) {
    $org            = new Organization();
    $org->name      = $request->organizationName;
    $org->is_public = $request->isPublic;
    return $org;
  }

  public function columnMap(): array {
    return [
      'id'         => 'id',
      'name'       => 'name',
      'is_public'  => 'isPublic',
      'location'   => 'location',
      'created_at' => 'createdAt',
    ];
  }

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("organizations");
    $this->skipAttributesOnCreate(['id']);

    $this->addBehavior(
      new \Phalcon\Mvc\Model\Behavior\Timestampable([
        'beforeCreate' => [
          'field'  => 'created_at',
          'format' => 'Y-m-d H:i:s',
        ],
      ])
    );

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