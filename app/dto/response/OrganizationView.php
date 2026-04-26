<?php
namespace App\Dto\Response;

class OrganizationView {
  public $orgId;
  public $orgName;
  public $orgEmail;
  public $orgOwnerId;
  public $orgOwnerName;
  public $userRole;

  public static function fromRow($row): self {
    $org               = new OrganizationView();
    $org->orgId        = $row['orgId'];
    $org->orgName      = $row['orgName'];
    $org->orgEmail     = $row['orgEmail'];
    $org->orgOwnerId   = $row['ownerId'];
    $org->orgOwnerName = $row['ownerName'];
    $org->userRole     = $row['userRole'];
    return $org;
  }
}