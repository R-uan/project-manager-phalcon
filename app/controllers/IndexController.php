<?php
declare (strict_types = 1);

class IndexController extends ControllerBase {
  public function indexAction() {
    if ($this->request->isGet()) {
      $this->view->setVar('userId', $this->session->get('authUserId'));
    }
  }
}
