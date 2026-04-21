<?php
namespace App\Repositories\Interfaces;

use App\Models\OrganizationInvite;

interface IInviteRepository {
  /** @return OrganizationInvite[] */
  public function findOrganizationInvitees(int $orgId): array;
  /** @return OrganizationInvite[] */
  public function findUserInvitations(int $userId): array;
  public function save(OrganizationInvite $orgInvite): bool;
  public function delete(OrganizationInvite $orgInvite): bool;
  public function findInvitation(int $inviteeId, int $orgId): ?OrganizationInvite;
}