<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class OrganizationInvite extends Model {
  public $inviterUserId;  // The one that invited
  public $inviteeUserId;  // The one invited
  public $organizationId; // to where
  public $createdAt;

  public static function from(int $invitee, int $inviter, int $orgId): self {
    $invite                 = new self();
    $invite->inviterUserId  = $inviter;
    $invite->inviteeUserId  = $invitee;
    $invite->organizationId = $orgId;
    return $invite;
  }

  public function columnMap(): array {
    return [
      'invitee_user_id' => 'inviteeUserId',
      'inviter_user_id' => 'inviterUserId',
      'organization_id' => 'organizationId',
      'created_at'      => 'createdAt',
    ];
  }

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("organization_invites");

    $this->belongsTo(
      "invitee_user_id",
      User::class,
      "id"
    );

    $this->belongsTo(
      "inviter_user_id",
      User::class,
      "id"
    );

    $this->belongsTo(
      "organization_id",
      Organization::class,
      "id"
    );
  }
}