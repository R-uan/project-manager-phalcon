<?php

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Repositories\Interfaces\IOrganizationRepository;
use App\Services\Interfaces\IOrganizationService;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class OrganizationService implements IOrganizationService {
  public function __construct(
    private IOrganizationRepository $organizationRepository,
    private IMembershipRepository $membershipRepository,
  ) {}

  public function findAll(): ResultsetInterface {
    return $this->organizationRepository->findAll();
  }

  public function createOrganization(User $user, CreateOrganizationRequestDto $request): Organization {
    $manager     = new TxManager();
    $transaction = $manager->get();

    try {
      $organization = Organization::fromRequest($request);
      $organization->setTransaction($transaction);

      if ($this->organizationRepository->save($organization) === false) {
        throw new \Exception("Failed to create organization");
      }

      $organization->refresh();
      $membership = Membership::from($user->id, $organization->id, "OWNER");
      $membership->setTransaction($transaction);

      if ($this->membershipRepository->save($membership) === false) {
        throw new \Exception("Failed to create membership");
      }

      $transaction->commit();
      return $organization;
    } catch (\Throwable $th) {
      $transaction->rollback($th->getMessage());
      throw $th;
    }
  }

  public function addMember(): bool {
    throw new \Exception('Not implemented');
  }

  public function deleteOrganization(User $user, int $org_id): bool {
    throw new \Exception('Not implemented');
  }
}