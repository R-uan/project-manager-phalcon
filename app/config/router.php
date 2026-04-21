<?php

$router = new \Phalcon\Mvc\Router(false);

$router->addGet('/', [
  'controller' => 'index',
  'action'     => 'index',
]);

// Authentication Endpoints
$router->add('/auth/login', [
  'controller' => 'auth',
  'action'     => 'login',
]);

$router->add('/auth/register', [
  'controller' => 'auth',
  'action'     => 'register',
]);

$router->add('/auth/logout', [
  'controller' => 'auth',
  'action'     => 'logout',
]);

// Organization Endpoints
$router->add('/organization', [
  'controller' => 'organization',
  'action'     => 'index',
]);

$router->add('/organization/create', [
  'controller' => 'organization',
  'action'     => 'create',
]);

$router->add('/organization/{orgId}/members', [
  'controller' => 'organization',
  'action'     => 'members',
]);

// User Endpoints
$router->add('/user', [
  'controller' => 'user',
  'action'     => 'index',
]);

$router->add('/user/memberships', [
  'controller' => 'user',
  'action'     => 'memberships',
]);

$router->add('/user/profile', [
  'controller' => 'user',
  'action'     => 'profile',
]);

$router->add('/user/profile/memberships', [
  'controller' => 'user',
  'action'     => 'memberships',
]);

return $router;