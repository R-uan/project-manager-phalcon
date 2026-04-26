<?php
namespace App\Repositories;

use App\Dto\Response\OrganizationView;
use App\Models\Organization;
use App\Repositories\Interfaces\IOrganizationRepository;

class OrganizationRepository implements IOrganizationRepository {

  public function __construct(
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function save(Organization $org): bool {
    return $org->save();
  }

  public function findUserOrganizations(int $userId): array {
    $organizations = $this->modelsManager->createQuery("
      SELECT
        ms.role AS userRole,
        o.name AS orgName, o.id AS orgId,
        CONCAT(ou.firstName, ' ', ou.lastName) AS ownerName, ou.id AS ownerId,
        oc.email AS orgEmail
      FROM App\Models\Organization o
      LEFT JOIN App\Models\Membership ms ON ms.orgId = o.id
      LEFT JOIN App\Models\OrganizationContact oc ON oc.orgId = o.id
      LEFT JOIN App\Models\Membership oms ON oms.orgId = o.id AND oms.role = 'OWNER'
      LEFT JOIN App\Models\User ou ON oms.userId = ou.id
      WHERE ms.orgId = o.id AND ms.userId = :userId:
    ")->execute(['userId' => $userId]);

    return array_map(function ($row) {
      return OrganizationView::fromRow($row);
    }, iterator_to_array($organizations));
  }

  public function findOrganizationById(int $id): ?Organization {
    /** @var Organization|null */
    return Organization::findFirst([
      'conditions' => 'id = :id:',
      'bind'       => ['id' => $id],
    ]);
  }
}