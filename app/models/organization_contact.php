<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class OrganizationContact extends Model {
  public $id;
  public $website;
  public $email;
  public $number;
  public $organization_id;

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("org_contacts");

    $this->belongsTo(
      'organization_id',
      Organization::class,
      'id',
    );
  }
}