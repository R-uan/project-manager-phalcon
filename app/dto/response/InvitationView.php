<?php
namespace App\Dto\Response;

class InvitationView {
  public function __construct(
    public $userId,
    public $orgId,
    public $orgName,
    public $inviterId,
    public $inviterName,
  ) {}

  public static function fromRow(mixed $row) {
    return new self(
      $row['userId'],
      $row['orgId'],
      $row['orgName'],
      $row['inviterId'],
      $row['inviterName'],
    );
  }
}