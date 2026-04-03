<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller {
    public function indexAction() {
        $this->view->disable();
        return $this->response->setContent("<h1>Hello</h1>");    
    }

    public function profileAction($username)
    {
        // Equivalent to return Ok(new { User = username });
        $this->view->disable(); // Stop rendering a .phtml file
        echo json_encode(["user" => $username]);
    }
}