<?php

use App\Dto\Response\ProfileView;

class UserController extends ControllerBase {
  // /user/{username}
  public function profileAction() {
    $this->assets->addCss('css/user/profile.css');
    try {
      $username = $this->dispatcher->getParam('username', 'string');

      /** @var ProfileView */
      $profile = $this->userService->getUserProfile($username);

      // if not authenticated as the username
      // remove all the private memberships.
      if ($username !== $this->session->get('username')) {
        $profile->memberships = array_filter($profile->memberships, function ($entry) {
          return $entry->isPublic === true;
        });
      }

      $this->view->setVar('profile', $profile);
    } catch (\Throwable $th) {
      $this->response->redirect('/');
    }
  }

  // /user/organizations
  public function organizationsAction() {
    $this->assets->collection('js')->addJs('js/user/organizations.js');
    $this->assets->collection('css')->addCss('css/user/organizations.css');

    try {
      $userId = (int)$this->session->get('authUserId');

      if (isset($userId) === false) {
        $this->flashSession->error("Authentication necessary");
        return $this->response->redirect('/auth/login');
      }

      $user = $this->userService->findUserById($userId);

      if ($user === null) {
        $this->flashSession->error("Authentication necessary");
        return $this->response->redirect('/auth/login');
      }

      if ($this->request->isGet()) {
        $memberships = $this->membershipService->findUserMemberships($userId);
        $invitations = $this->inviteService->findUserInvitations($userId);

        $this->view->setVar('memberships', $memberships);
        $this->view->setVar('invitations', $invitations);
        $this->view->pick('user/organizations');
      }
    } catch (\Throwable $th) {
      $this->flashSession->error($th->getMessage());
    }
  }

  // /user -> /user/profile
  // just redirects to profile.
  public function indexAction() {
    $username = $this->session->get('authUsername');
    if (isset($username) === false) {return $this->response->redirect('/auth/login');}
    return $this->response->redirect('/user/' . $username);
  }
}