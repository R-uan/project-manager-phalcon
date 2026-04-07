<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller {
  public function indexAction() {
    $this->view->disable();
    $token = $this->userService->test();
    return $this->response->setContent($token);
  }
}