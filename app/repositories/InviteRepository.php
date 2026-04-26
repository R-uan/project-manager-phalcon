<?php
namespace App\Repositories;

use App\Dto\Response\InvitationView;
use App\Models\OrganizationInvite;
use App\Repositories\Interfaces\IInviteRepository;

class InviteRepository implements IInviteRepository {
  public function __construct(
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function findInvitation(int $orgId, int $inviteeId): ?InvitationView {
    throw new \Exception('Not implemented');
  }

  public function save(OrganizationInvite $orgInvite): bool {
    return $orgInvite->save();
  }

  public function delete(int $orgId, int $inviteeId): bool {
    $invitation = OrganizationInvite::findFirst([
      'conditions' => 'orgId = :orgId: AND inviteeId = :inviteeId:',
      'bind'       => ['orgId' => $orgId, 'inviteeId' => $inviteeId],
    ]) ?? throw new \Exception("Invitation not found.");
    return $invitation->delete();
  }

  public function findUserInvitations(int $userId): array {
    $invitations = $this->modelsManager->createQuery('
      SELECT
        oi.inviteeUserId AS userId,
        o.name AS orgName, o.id AS orgId,
        uir.firstName AS inviterName, uir.id AS inviterId
      FROM App\Models\OrganizationInvite oi
      LEFT JOIN App\Models\User uir ON uir.id = oi.inviterUserId
      LEFT JOIN App\Models\Organization o ON o.id = oi.organizationId
      WHERE inviteeUserId = :userId:
    ')->execute(['userId' => $userId]);

    return array_map(function ($row) {
      return InvitationView::fromRow($row);
    }, iterator_to_array($invitations));
  }

  public function findOrganizationInvitations(int $orgId): array {
    $invitations = $this->modelsManager->createQuery('
      SELECT *
      FROM organization_invites
      WHERE organization_id = :orgId:
    ')->execute(['orgId' => $orgId]);
    return iterator_to_array($invitations);
  }
}