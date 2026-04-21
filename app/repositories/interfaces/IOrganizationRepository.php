<?php
namespace App\Repositories\Interfaces;

use App\Models\Organization;

interface IOrganizationRepository {
  public function save(Organization $org): bool;

  /** @return Organization[] */
  public function findAll(): array;
  public function findById(int $id): ?Organization;
}