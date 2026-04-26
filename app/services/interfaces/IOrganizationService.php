<?php
namespace App\Services\Interfaces;

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Organization;

interface IOrganizationService {
  public function findUserOrganizations(int $userId): array;

  public function deleteOrganization(int $userId, int $orgId): bool;
  public function createOrganization(int $userId, CreateOrganizationRequestDto $request): Organization;

  public function inviteUser(int $inviterId, int $orgId, string $inviteeEmail): bool;
}