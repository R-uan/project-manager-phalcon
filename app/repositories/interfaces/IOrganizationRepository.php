<?php
namespace App\Repositories\Interfaces;

use App\Models\Organization;
use App\Models\User;
use Phalcon\Mvc\Model\ResultsetInterface;

interface IOrganizationRepository {
  public function save(Organization $org): bool;

  public function findAll(): ResultsetInterface;
  public function findById(int $id): ?Organization;

  public function findMembers(int $orgId): ResultsetInterface;
  public function addMember(User $user, Organization $org): bool;
  public function removeMember(User $user, Organization $org): bool;
}