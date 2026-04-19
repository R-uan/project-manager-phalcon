<?php
declare (strict_types = 1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
  public function onConstruct() {
    $this->assets
      ->collection('page-css')
      ->addCss('css/app.css');
  }
}
