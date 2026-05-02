<?php
namespace App\Dto\Response;

class OrganizationView {
  public $orgId;
  public $orgHandle;
  public $orgEmail;
  public $orgOwnerId;
  public $orgOwnerName;
  public $userRole;

  public static function fromRow($row): self {
    $org               = new OrganizationView();
    $org->orgId        = $row['orgId'];
    $org->orgHandle    = $row['orgHandle'];
    $org->orgEmail     = $row['orgEmail'];
    $org->orgOwnerId   = $row['ownerId'];
    $org->orgOwnerName = $row['ownerName'];
    $org->userRole     = $row['userRole'];
    return $org;
  }
}