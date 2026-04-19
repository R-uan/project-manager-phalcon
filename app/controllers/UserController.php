<?php

use App\Dto\Request\CreateUserRequestDto;
use App\Dto\Response\ProfileView;
use App\Models\User;

class UserController extends ControllerBase {
  public function registerAction() {
    $body     = $this->request->getJsonRawBody(true);
    $request  = CreateUserRequestDto::fromArray($body);
    $validate = $request->validate();

    if ($validate !== true) {
      return $this->response
        ->setStatusCode(400)
        ->setJsonContent(['errors' => $validate]);
    }

    $response = $this->userService->createUser($request);
    return $this->response->setStatusCode(200)->setJsonContent([
      'message' => 'Sucessfully registered user.',
      'data'    => $response,
    ]);
  }

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

  // /user/profile/memberships
  public function membershipsAction() {
    $userId = (int)$this->session->get('auth_user_id');

    if (! $userId) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    $user = $this->userRepository->findById($userId);

    if ($user === null) {
      $this->flashSession->error("Authentication necessary");
      return $this->response->redirect('/auth/login');
    }

    if ($this->request->isGet()) {
      $memberships = $this->membershipService->findUserMemberships($userId);
      $this->view->setVar('memberships', $memberships);
      $this->view->pick('user/memberships');
    }
  }

  // /user -> /user/profile
  // just redirects to profile.
  public function indexAction() {
    return $this->response->redirect('/user/profile');
  }
}