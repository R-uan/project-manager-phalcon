<?php

use App\Dto\Response\ProfileView;
use App\Models\User;

class UserController extends ControllerBase {
  // /user/profile
  public function profileAction() {
    $userId = (int)$this->session->get('auth_user_id');

    if (! $userId) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    /** @var User|null */
    $user = $this->userRepository->findById($userId);

    if ($user === null) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    /** @var MembershipView[] */
    $memberships = $this->membershipRepository->findUserMemberships($user->id);
    $profile     = ProfileView::from($user, $memberships);
    $this->view->setVar('profile', $profile);
  }

  // /user/organizations
  public function organizationsAction() {
    try {
      $userId = (int)$this->session->get('auth_user_id');

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

        $this->view->setVar('membershipsJson', json_encode(array_map(fn($m) => [
          'orgId'   => $m->orgId,
          'orgName' => $m->orgName,
          'role'    => $m->role,
        ], $memberships)));

        $this->view->setVar('invitationsJson', json_encode(array_map(fn($i) => [
          'orgId'       => $i->orgId,
          'orgName'     => $i->orgName,
          'inviterName' => $i->inviterName,
        ], $invitations)));

        $this->view->pick('user/organizations');
      }
    } catch (\Throwable $th) {
      $this->flashSession->error($th->getMessage());
    }
  }

  // /user -> /user/profile
  // just redirects to profile.
  public function indexAction() {
    return $this->response->redirect('/user/profile');
  }
}