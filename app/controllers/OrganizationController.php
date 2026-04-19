<?php

use App\Dto\Request\CreateOrganizationRequestDto;
use App\Models\Organization;
use App\Models\User;

class OrganizationController extends ControllerBase {
  public function indexAction() {
    $organizations = $this->organizationService->findAll();
    $this->view->setVar('organizations', $organizations);
  }

  public function membersAction() {
    if ($this->request->isGet()) {
      try {
        $orgId   = $this->dispatcher->getParam('orgId', 'int');
        $members = $this->organizationService->findOrganizationMembers($orgId);
        $this->view->setVar('members', $members);
      } catch (\Throwable $th) {
        throw $th;
      }
    }
  }

  public function createAction() {
    $this->assets->addCss('css/organization.css');

    if (! $this->session->get('auth_user_id')) {
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

        /** @var User|null */
        $user = $this->userService->findUserById($this->session->get('auth_user_id'));

        if ($user === null) {
          // this would be a weird outcome lol
          $this->flashSession->error("You are not authorized to make this request.");
          return $this->response->redirect('/auth/login');
        }

        /** @var Organization */
        $this->organizationService->createOrganization($user, $request);
        return $this->response->redirect('/organization');
      } catch (\Throwable $th) {
        $this->flashSession->error($th->getMessage());
        return $this->response->redirect('/organization/create');
      }
    }
  }
}