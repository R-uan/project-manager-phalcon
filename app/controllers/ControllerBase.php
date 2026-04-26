<?php
declare (strict_types = 1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
  public function onConstruct() {
    $this->assets
      ->collection('css')
      ->addCss('css/app.css');

    $this->assets->collection('js')
      ->addJs("js/jquery-4.0.0.min.js.js");
  }
}
