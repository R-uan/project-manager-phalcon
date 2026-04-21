<?php

use App\Models\Membership;
use App\Models\Organization;
use App\Models\OrganizationInvite;
use App\Models\User;
use App\Repositories\Interfaces\IInviteRepository;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IInviteService;

class InviteService implements IInviteService {
  public function __construct(
    private IInviteRepository $inviteRepository,
    private IUserRepository $userRepository,
    private IMembershipRepository $membershipRepository,
  ) {}

  public function sendInvitation(int $inviterId, Organization $org, User $invitee): bool {
    $invitation = OrganizationInvite::from(
      inviter: $inviterId,
      invitee: $invitee->id,
      orgId: $org->id
    );
    return $this->inviteRepository->save($invitation);
  }

  public function acceptInvitation(int $inviteeId, int $orgId): bool {
    $invitee = $this->userRepository->findById($inviteeId);
    if (isset($invitee) === null) {
      throw new \Exception("User not found.");
    }

    if ($this->inviteRepository->findInvitation($inviteeId, $orgId) === null) {
      throw new \Exception("Invitation was not found");
    }

    $membership = Membership::from($invitee->id, $orgId, "MEMBER");
    return $this->membershipRepository->save($membership);
  }

  public function revokeInvitation(int $orgId, int $inviterId, int $inviteeId): bool {
    $invitation = $this->inviteRepository->findInvitation($inviteeId, $orgId) ??
    throw new Exception("Invitation was not found.");

    $inviter = $this->membershipRepository->findMembership($orgId, $inviterId) ??
    throw new \Exception("Inviter is not a member of this organization.");

    if ($inviter->role !== "OWNER") {
      throw new \Exception("You are not authorized to do this operation.");
    }

    return $this->inviteRepository->delete($invitation);
  }
}