<?php

use App\Dto\Response\InvitationView;
use App\Dto\Response\MembershipView;
use App\Models\Membership;
use App\Models\OrganizationInvite;
use App\Repositories\Interfaces\IInviteRepository;
use App\Services\Interfaces\IInviteService;
use App\Services\Interfaces\IMembershipService;
use App\Services\Interfaces\IUserService;

class InviteService implements IInviteService {
  public function __construct(
    private IInviteRepository $inviteRepository,
    private IMembershipService $membershipService,
    private IUserService $userService,
  ) {}

  /** @return InvitationView[] */
  public function findUserInvitations(int $userId): array {
    return $this->inviteRepository->findUserInvitations($userId);
  }

  /** @return InvitationView[] */
  public function findOrganizationInvitations(int $orgId): array {
    return $this->inviteRepository->findOrganizationInvitations($orgId);
  }

  /** @return InvitationView */
  public function findInvitation(int $inviteeId, int $orgId): ?InvitationView {
    return $this->inviteRepository->findInvitation($inviteeId, $orgId);
  }

  public function createInvitation(int $orgId, int $inviteeId, int $inviterId): bool {
    $invitation = $this->findInvitation($inviteeId, $orgId);

    if (isset($invitation) === true) {
      throw new \Exception("User already invited");
    }

    $newInvitation = OrganizationInvite::from(
      orgId: $orgId,
      inviter: $inviterId,
      invitee: $inviteeId
    );

    return $this->inviteRepository->save($newInvitation);
  }

  public function acceptInvitation(int $orgId, int $inviteeId): MembershipView {
    $invitee = $this->userService->findUserById($inviteeId) ??
    throw new \Exception("User not found.");

    if ($this->inviteRepository->findInvitation($orgId, $inviteeId) === null) {
      throw new \Exception("Invitation was not found");
    }

    $membership = Membership::from($invitee->id, $orgId, "MEMBER");
    if ($this->membershipService->createMembership($membership) === false) {
      throw new \Exception("Unable to create membership.");
    }

    $membership = $this->membershipService->findMembership($orgId, $inviteeId) ??
    throw new \Exception("Unable to find created invitation.");
    $this->inviteRepository->delete($orgId, $inviteeId);
    return $membership;
  }

  public function deleteInvitation(int $orgId, int $inviteeId, int $inviterId): bool {
    $inviter = $this->membershipService->findMembership($orgId, $inviterId) ??
    throw new \Exception("Inviter is not a member of this organization.");

    if ($inviter->role !== "OWNER") {
      throw new \Exception("You are not authorized to do this operation.");
    }

    return $this->inviteRepository->delete($orgId, $inviteeId);
  }
}