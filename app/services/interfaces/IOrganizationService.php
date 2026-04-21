<?php
namespace App\Services\Interfaces;

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Organization;
use App\Models\User;

interface IOrganizationService {
  /** @return Membership[] */
  public function findAll(): array;
  /** @return Membership[] */
  public function findOrganizationMembers(int $orgId): array;
  public function deleteOrganization(User $user, int $orgId): bool;
  public function inviteUser(int $inviterId, int $orgId, string $inviteeEmail): bool;
  public function createOrganization(User $user, CreateOrganizationRequestDto $request): Organization;
}