<?php
namespace App\Repositories\Interfaces;

use App\Models\Organization;

interface IOrganizationRepository {
  public function save(Organization $org): bool;
  public function findById(int $id): ?Organization;
  public function findUserOrganizations(int $userId): array;
  public function findByHandle(string $handle): ?Organization;
}