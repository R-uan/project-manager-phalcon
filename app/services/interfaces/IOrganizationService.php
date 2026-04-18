<?php
namespace App\Services\Interfaces;

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Organization;
use App\Models\User;
use Phalcon\Mvc\Model\ResultsetInterface;

interface IOrganizationService {
  public function findAll(): ResultsetInterface;
  public function addMember(): bool;
  public function deleteOrganization(User $user, int $org_id): bool;
  public function createOrganization(User $user, CreateOrganizationRequestDto $request): Organization;
}