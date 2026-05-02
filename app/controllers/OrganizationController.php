<?php

use App\Dto\Request\CreateOrganizationRequestDto;

class OrganizationController extends ControllerBase {
  // /organization
  // Renders a list of the user's organizations which they are member of.
  // - Authentication required.
  public function indexAction() {
    $this->assets->collection('js')->addJs('js/organization/index.js');
    $this->assets->collection('css')->addCss('css/organization/index.css');

    $userId = $this->session->get('authUserId');

    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    $organizations = $this->organizationService->findUserOrganizations($userId);
    $this->view->setVar('organizations', $organizations);
  }

  public function membersAction() {
    $userId = $this->session->get("authUserId");
    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect("/auth/login");
    }

    $orgId = $this->dispatcher->getParam('orgId', 'int');
    if ($this->organizationService->findOrganization($orgId) === null) {
      $this->flashSession->error("Organization does not exist");
      return $this->response->redirect("/organization");
    }

    try {
      $memberships = $this->membershipService->findOrganizationMemberships($userId, $orgId);
      $this->view->setVar('memberships', $memberships);
    } catch (\Throwable $th) {
      $this->flashSession->error($th->getMessage());
    }
  }

  public function newOrganizationAction() {
    $this->view->disable();
    $userId = $this->session->get("authUserId");

    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    try {
      $request = CreateOrganizationRequestDto::fromArray([
        'handle'       => $this->request->getPost('handle'),
        'displayName'  => $this->request->getPost('name'),
        'contactEmail' => $this->request->getPost('contactEmail'),
        'isPublic'     => $this->request->getPost('visibility'),
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
      throw $th;
      $this->flashSession->error($th->getMessage());
      return $this->response->redirect('/organization/new');
    }
  }

  public function newOrganizationFormAction() {
    $this->assets->addCss('css/organization/new.css');
    $this->assets->addJs('js/organization/new.js');

    $this->view->pick('organization/new');

    if ($this->session->get('authUserId') === null) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }
  }

  public function inviteAction() {
    $this->view->disable();
    $userId = $this->session->get("authUserId");
    if (isset($userId) === false) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect("/auth/login");
    }

    $orgId = $this->dispatcher->getParam('orgId', 'int');
    if ($this->organizationService->findOrganization($orgId) === null) {
      $this->flashSession->error("Organization does not exist");
      return $this->response->redirect("/organization");
    }

    try {
      $targetUserEmail = $this->request->getPost('targetEmail');

      if (isset($targetUserEmail) === false) {
        $this->flashSession->error("Target user required");
        return;
      }

      if ($this->organizationService->inviteUser($userId, $orgId, $targetUserEmail) === false) {
        $this->flashSession->error("Could not invite member.");
        return;
      }

      $this->flashSession->success("Member invited.");
      return $this->response->redirect('/organization/' . $orgId . '/members');
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function acceptAction() {
    $this->view->disable();
    $orgId  = $this->dispatcher->getParam('orgId', 'int');
    $userId = $this->session->get('authUserId');
    try {
      if (isset($userId) === false) {
        return $this->response->setStatusCode(401)->setJsonContent([
          'success' => false,
          'message' => 'unauthorized',
        ]);
      }

      $membership = $this->inviteService->acceptInvitation($orgId, $userId);
      return $this->response->setJsonContent(json_encode($membership));
    } catch (\Throwable $th) {
      return $this->response->setStatusCode(500)->setJsonContent([
        'message' => json_encode($th->getMessage()),
      ]);
    }
  }

  public function denyAction() {

  }

  public function checkAvailabilityAction() {
    $this->view->disable();
    $field   = $this->request->getQuery('field');
    $value   = $this->request->getQuery('value');
    $allowed = ['handle'];

    if (in_array($field, $allowed) === false) {
      return $this->response->setStatusCode(403)->setJsonContent([
        'available' => 'false',
        'message'   => 'invalid field',
      ]);
    }

    /** @return bool */
    $available = $this->organizationService->verifyHandleAvailability($value);

    return $this->response->setStatusCode(200)->setJsonContent([
      'available' => $available,
      'message'   => $field . ($available ? ' is available.' : ' is not available.'),
    ]);
  }
}