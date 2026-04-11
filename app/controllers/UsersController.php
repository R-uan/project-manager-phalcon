<?php

use App\Dto\Request\CreateUserRequestDto;
use Phalcon\Mvc\Controller;

class UsersController extends Controller {
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

  public function indexAction() {
    $this->view->disable();
    $token = $this->userService->test();
    return $this->response->setContent($token);
  }
}