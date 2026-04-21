<?php
namespace App\Repositories;

use App\Models\OrganizationInvite;
use App\Repositories\Interfaces\IInviteRepository;

class InviteRepository implements IInviteRepository {
  public function __construct(
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function findInvitation(int $inviteeId, int $orgId): ?OrganizationInvite {
    throw new \Exception('Not implemented');
  }

  public function save(OrganizationInvite $orgInvite): bool {
    return $orgInvite->save();
  }

  public function delete(OrganizationInvite $orgInvite): bool {
    return $orgInvite->delete();
  }

  public function findUserInvitations(int $userId): array {
    $invitations = $this->modelsManager->createQuery('
      SELECT *
      FROM organization_invites
      WHERE invitee_user_id = :userId:
    ')->execute(['userId' => $userId]);
    return iterator_to_array($invitations);
  }

  public function findOrganizationInvitees(int $orgId): array {
    $invitations = $this->modelsManager->createQuery('
      SELECT *
      FROM organization_invites
      WHERE organization_id = :orgId:
    ')->execute(['orgId' => $orgId]);
    return iterator_to_array($invitations);
  }
}