<?php
namespace App\Repositories\Interfaces;

use App\Models\Organization;

interface IOrganizationRepository {
  public function save(Organization $org): bool;
  public function findOrganizationById(int $id): ?Organization;
  public function findUserOrganizations(int $userId): array;
}