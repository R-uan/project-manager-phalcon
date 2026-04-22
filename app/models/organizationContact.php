<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class OrganizationContact extends Model {
  public $id;
  public $email;
  public $number;
  public $website;
  public $organizationId;

  public function columnMap(): array {
    return [
      'id'              => 'id',
      'email'           => 'email',
      'number'          => 'number',
      'website'         => 'website',
      'organization_id' => 'organizationId',
    ];
  }

  public static function from(int $orgId, string $email): self {
    $contacts                 = new self();
    $contacts->email          = $email;
    $contacts->organizationId = $orgId;
    return $contacts;
  }

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("organization_contacts");
    $this->skipAttributesOnCreate(['id']);

    $this->belongsTo(
      'organization_id',
      Organization::class,
      'id',
    );
  }
}