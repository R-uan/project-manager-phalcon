<?php
namespace App\Repositories\Interfaces;

use App\Dto\Response\InvitationView;
use App\Models\OrganizationInvite;

interface IInviteRepository {
  public function save(OrganizationInvite $orgInvite): bool;
  public function delete(int $orgId, int $inviteeId): bool;

  public function findUserInvitations(int $userId): array;
  public function findOrganizationInvitations(int $orgId): array;
  public function findInvitation(int $orgId, int $inviteeId): ?InvitationView;
}