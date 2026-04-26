<?php

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Organization;

class OrganizationController extends ControllerBase {
  // /organization
  // Renders a list of the user's organizations which they are member of.
  // - Authentication required.
  public function indexAction() {
    $this->assets->collection('js')->addJs('js/organization/index.js');
    $this->assets->collection('css')->addCss('css/organization/index.css');

    $userId = $this->session->get('auth_user_id');

    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    $organizations = $this->organizationService->findUserOrganizations($userId);
    $this->view->setVar('organizations', $organizations);
  }

  // /organization/{orgId}/members
  // Renders a list of the organization's members, user needs to be part of the organization
  // - Authentication required;
  public function membersAction() {
    $userId = $this->session->get('auth_user_id');
    if (isset($userId) === false) {
      $this->flashSession->error("Authentication required.");
      return $this->response->redirect('/auth/login');
    }

    if ($this->request->isGet()) {
      try {
        $orgId   = $this->dispatcher->getParam('orgId', 'int');
        $members = $this->membershipService->findOrganizationMemberships($orgId);
        $this->view->setVar('members', $members);
      } catch (\Throwable $th) {
        throw $th;
      }
    }

    if ($this->request->isPost()) {
      try {

        $targetUserEmail = $this->request->getPost('targetEmail');
        if (isset($targetUserEmail) === false) {
          $this->flashSession->error("Target user required");
          return;
        }

        $orgId = $this->dispatcher->getParam('orgId', 'int');
        if ($this->organizationService->inviteUser($userId, $orgId, $targetUserEmail) === false) {
          $this->flashSession->error("Could not invite member.");
          return;
        }

        $this->flashSession->success("Member invited.");
        return $this->response->redirect('/organization/' . $orgId . '/members');
      } catch (\Throwable $th) {
        $this->flashSession->error($th->getMessage());
        return $this->response->redirect('/organization/' . $orgId . '/members');
      }
    }
  }

  // /organization/new
  // Creates new organization.
  // - Authentication required;
  public function newAction() {
    $this->assets->addCss('css/organization/new.css');
    $userId = $this->session->get('auth_user_id');

    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    if ($this->request->isPost()) {
      try {
        $request = CreateOrganizationRequestDto::fromArray([
          'name'         => $this->request->getPost('name'),
          'contactEmail' => $this->request->getPost('contactEmail'),
          'isPublic'     => $this->request->getPost('isPublic') ?? false,
        ]);

        $validate = $request->validate();

        if ($validate !== true) {
          foreach ($validate as $error) {
            $this->flashSession->error($error);
          }
          return;
        }

        /** @var Organization */
        $this->organizationService->createOrganization($userId, $request);
        return $this->response->redirect('/organization');
      } catch (\Throwable $th) {
        $this->flashSession->error($th->getMessage());
        return $this->response->redirect('/organization/create');
      }
    }
  }

  // /organization/invite/accept
  public function acceptInvitationAction() {
    $this->view->disable();
    if ($this->request->isPost()) {
      try {
        $userId = (int)$this->session->get("auth_user_id");
        $orgId  = $this->dispatcher->getParam('orgId', 'int');

        if (isset($userId) === false) {return $this->response->redirect("/auth/login");}
        $membership = $this->inviteService->acceptInvitation($userId, $orgId);
        $this->response->setJsonContent([
          'success'    => true,
          'membership' => [
            'orgId'   => $membership->orgId,
            'orgName' => $membership->orgName,
            'role'    => $membership->role,
          ],
        ]);
      } catch (\Throwable $th) {
        $this->response->setStatusCode(400);
        $this->response->setJsonContent([
          'success' => false,
          'message' => $th->getMessage(),
        ]);
      }
      return $this->response->send();
    }
  }

  public function declineInviteAction() {

  }
}