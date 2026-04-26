<?php
namespace App\Services\Interfaces;

use App\Dto\Response\InvitationView;
use App\Dto\Response\MembershipView;

interface IInviteService {
  public function findUserInvitations(int $userId): array;
  public function findOrganizationInvitations(int $orgId): array;
  public function findInvitation(int $userId, int $orgId): ?InvitationView;

  public function acceptInvitation(int $orgId, int $inviteeId): MembershipView;
  public function deleteInvitation(int $orgId, int $inviteeId, int $inviterId): bool;
  public function createInvitation(int $orgId, int $inviteeId, int $inviterId): bool;
}