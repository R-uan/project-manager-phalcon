<?php
namespace App\Repositories;

use App\Models\Organization;
use App\Repositories\Interfaces\IOrganizationRepository;

class OrganizationRepository implements IOrganizationRepository {

  public function __construct(
    private MembershipRepository $membershipRepository,
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function save(Organization $org): bool {
    return $org->save();
  }

  public function findAll(): array {
    $organizations = $this->modelsManager->createQuery('
      SELECT
        *
      FROM organizations;
    ')->execute();
    return iterator_to_array($organizations);
  }

  public function findById(int $id): ?Organization {
    /** @var Organization|null */
    return Organization::findFirst([
      'conditions' => 'id = :id:',
      'bind'       => ['id' => $id],
    ]);
  }
}