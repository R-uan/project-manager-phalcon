<?php

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\User;
use App\Repositories\Interfaces\IOrganizationRepository;
use App\Services\Interfaces\IInviteService;
use App\Services\Interfaces\IMembershipService;
use App\Services\Interfaces\IOrganizationService;
use App\Services\Interfaces\IUserService;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class OrganizationService implements IOrganizationService {
  public function __construct(
    private IOrganizationRepository $organizationRepository,
    private IMembershipService $membershipService,
    private IInviteService $inviteService,
    private IUserService $userService,
  ) {}

  public function findUserOrganizations(int $userId): array {
    return $this->organizationRepository->findUserOrganizations($userId);
  }

  /** @return Organization */
  public function createOrganization(int $userId, CreateOrganizationRequestDto $request): Organization {
    $manager     = new TxManager();
    $transaction = $manager->get();

    try {
      $user = $this->userService->findUserById($userId);
      if (isset($user) === false) {throw new \Exception("Not authorized");}

      $organization = Organization::fromRequest($request);
      $organization->setTransaction($transaction);

      if ($this->organizationRepository->save($organization) === false) {
        throw new \Exception("Failed to create organization");
      }

      $organization->refresh(); // refreshes the entity to get the generated id
      $membership = Membership::from($user->id, $organization->id, "OWNER");
      $membership->setTransaction($transaction);

      if ($this->membershipService->createMembership($membership) === false) {
        throw new \Exception("Failed to create membership");
      }

      $contacts = OrganizationContact::from($organization->id, $request->contactEmail);
      $contacts->setTransaction($transaction);

      // im not making a whole repository for one function.
      if ($contacts->save() === false) {
        throw new \Exception("Failed to create membership");
      }

      $transaction->commit();
      return $organization;
    } catch (\Throwable $th) {
      $transaction->rollback($th->getMessage());
      throw $th;
    }
  }

  public function inviteUser(int $inviterId, int $orgId, string $inviteeEmail): bool {
    $org = $this->organizationRepository->findOrganizationById($orgId);
    var_dump($orgId);
    die;
    if (isset($org) === false) {
      throw new \Exception("Organization not found");
    }

    // Is the invitee the owner of the organization ?
    /** @var Membership|null */
    $actorMembership = $this->membershipService->findMembership($org->id, $inviterId);
    if (isset($actorMembership) === false | $actorMembership->role !== "OWNER") {
      throw new \Exception("You are not authorized to do this operation.");
    }

    /** @var User|null */
    $invitee = $this->userService->findUserByEmail($inviteeEmail) ??
    throw new \Exception("User was not found");

    if ($this->membershipService->findMembership($org->id, $invitee->id) !== null) {
      throw new \Exception("User is already a member.");
    }

    return $this->inviteService->createInvitation(
      orgId: $org->id,
      inviterId: $inviterId,
      inviteeId: $invitee->id
    );
  }

  public function deleteOrganization(int $userId, int $orgId): bool {
    throw new \Exception('Not implemented');
  }
}