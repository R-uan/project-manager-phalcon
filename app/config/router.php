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

$router->add('/organization/new', [
  'controller' => 'organization',
  'action'     => 'new',
]);

$router->add('/organization/{orgId}/members', [
  'controller' => 'organization',
  'action'     => 'members',
]);

$router->addPost('/organization/invites/accept', [
  'controller' => 'organization',
  'action'     => 'acceptInvitation',
]);

// User Endpoints
$router->add('/user', [
  'controller' => 'user',
  'action'     => 'index',
]);

$router->add('/user/organizations', [
  'controller' => 'user',
  'action'     => 'organizations',
]);

$router->add('/user/profile', [
  'controller' => 'user',
  'action'     => 'profile',
]);

return $router;