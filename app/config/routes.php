<?php

$router = new \Phalcon\Mvc\Router();
$router->addGet('/api/v1/users', [
  'controller' => 'users',
  'action'     => 'index',
]);

return $router;