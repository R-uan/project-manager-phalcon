<?php

use App\Dto\Request\CreateUserRequestDto;

class AuthController extends ControllerBase {
  #[Override]
  public function onConstruct() {
    $this->assets->collection('css')->addCss('css/auth.css');
    return parent::onConstruct();
  }

  public function loginAction() {
    if ($this->request->isPost()) {
      try {

        /** @return array */
        $info = $this->authService->authenticateUser(
          $this->request->getPost('email'),
          $this->request->getPost('password')
        );

        $this->session->set('authUserId', $info['userId']);
        $this->session->set('authUsername', $info['username']);

        $this->response->redirect('/');
      } catch (\Exception $e) {
        $this->flashSession->error($e->getMessage());
        $this->response->redirect('/auth/login');
      }
    } else {
      if ($this->session->get('authUserId')) {
        $this->response->redirect('/');
      }
    }

  }

  public function registerAction() {
    $this->assets->collection('js')->addJs('js/auth/register.js');

    if ($this->request->isPost()) {
      try {
        $request = CreateUserRequestDto::fromArray([
          'name'      => $this->request->getPost('name'),
          'email'     => $this->request->getPost('email'),
          'username'  => $this->request->getPost('username'),
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
      if ($this->session->get('authUserId')) {
        $this->response->redirect('/');
      }
    }
  }

  public function logoutAction() {
    $this->session->destroy();
    $this->response->redirect('/auth/login');
  }

  public function checkAvailabilityAction() {
    $this->view->disable();
    $field   = $this->request->getQuery('field');
    $value   = $this->request->getQuery('value');
    $allowed = ['username', 'email'];

    if (in_array($field, $allowed) === false) {
      return $this->response->setStatusCode(403)->setJsonContent([
        'available' => 'false',
        'message'   => 'invalid field',
      ]);
    }

    /** @return bool */
    $available = $this->userService->checkUniqueAvailability($field, $value);

    return $this->response->setStatusCode(200)->setJsonContent([
      'available' => $available,
      'message'   => $field . ($available ? ' is available.' : ' is not available.'),
    ]);
  }
}