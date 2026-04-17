<?php

use App\Dto\Request\CreateUserRequestDto;

class AuthController extends ControllerBase {

  public function loginAction() {
    if ($this->request->isPost()) {
      try {

        $this->authService->authenticateUser(
          $this->request->getPost('email'),
          $this->request->getPost('password')
        );

        $this->response->redirect('/');
      } catch (\Exception $e) {
        $this->flashSession->error($e->getMessage());
        $this->response->redirect('/auth/login');
      }
    } else {
      if ($this->session->get('auth_user_id')) {
        $this->response->redirect('/');
      }
    }

  }

  public function registerAction() {
    if ($this->request->isPost()) {
      try {
        $request = CreateUserRequestDto::fromArray([
          'name'      => $this->request->getPost('name'),
          'email'     => $this->request->getPost('email'),
          'password'  => $this->request->getPost('password'),
          'firstName' => $this->request->getPost('firstName'),
          'lastName'  => $this->request->getPost('lastName'),
        ]);

        $validate = $request->validate();

        if ($validate !== true) {
          foreach ($validate as $error) {
            $this->flashSession->error($error);
          }
          return $this->response->redirect('/auth/register');
        }

        if ($this->authService->registerUser($request)) {
          $this->flashSession->success('Account created successfully.');
          $this->response->redirect('/auth/login');
        }

      } catch (\Exception $e) {
        $this->flashSession->error($e->getMessage());
        $this->response->redirect('/auth/register');
      }
    } else {
      if ($this->session->get('auth_user_id')) {
        $this->response->redirect('/');
      }
    }
  }

  public function logoutAction() {
    $this->session->destroy();
    $this->response->redirect('/auth/login');
  }
}