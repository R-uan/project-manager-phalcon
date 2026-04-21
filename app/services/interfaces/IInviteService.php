<?php
namespace App\Services\Interfaces;

use App\Models\Organization;
use App\Models\User;

interface IInviteService {
  public function acceptInvitation(int $inviteeId, int $orgId): bool;
  public function revokeInvitation(int $orgId, int $inviterId, int $inviteeId): bool;
  public function sendInvitation(int $inviterId, Organization $org, User $invitee): bool;
}