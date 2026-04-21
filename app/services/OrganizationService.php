<?php

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\User;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Repositories\Interfaces\IOrganizationRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IInviteService;
use App\Services\Interfaces\IOrganizationService;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class OrganizationService implements IOrganizationService {
  public function __construct(
    private IOrganizationRepository $organizationRepository,
    private IMembershipRepository $membershipRepository,
    private IUserRepository $userRepository,
    private IInviteService $inviteService,
  ) {}

  public function findAll(): array {
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

  public function findOrganizationMembers(int $orgId): array {
    return $this->membershipRepository->findOrganizationMembers($orgId);
  }

  public function inviteUser(int $inviterId, int $orgId, string $inviteeEmail): bool {
    /** @var Organization|null */
    $org = $this->organizationRepository->findById($orgId);
    if (isset($org) === false) {
      throw new \Exception("Organization not found.");
    }

    // Is the invitee the owner of the organization ?
    /** @var Membership|null */
    $actorMembership = $this->membershipRepository->findMembership($org->id, $inviterId);
    if (isset($actorMembership) === false | $actorMembership->role !== "OWNER") {
      throw new \Exception("You are not authorized to do this operation.");
    }

    /** @var User|null */
    $invitee = $this->userRepository->findByEmail($inviteeEmail);

    if (isset($invitee) === false) {
      throw new \Exception("User was not found");
    }

    // Already a member ?
    $isMember = $this->membershipRepository->findMembership(
      orgId: $org->id,
      userId: $invitee->id,
    );

    if ($isMember !== null) {
      throw new \Exception("User is already a member.");
    }

    return $this->inviteService->sendInvitation(
      inviterId: $inviterId,
      invitee: $invitee,
      org: $org,
    );
  }

  public function deleteOrganization(User $user, int $orgId): bool {
    throw new \Exception('Not implemented');
  }
}