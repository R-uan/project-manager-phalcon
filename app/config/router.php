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

$router->addGet('/auth/verify-availability', 'auth::checkAvailability');

$router->add('/auth/logout', [
  'controller' => 'auth',
  'action'     => 'logout',
]);

// Organization Endpoints
$router->addGet('/org/verify-availability', 'organization::checkAvailability');

$router->add('/organization', [
  'controller' => 'organization',
  'action'     => 'index',
]);

$router->add('/organization/{orgId}/members', [
  'controller' => 'organization',
  'action'     => 'members',
]);

$router->addPost('/organization/new', "organization::newOrganization");
$router->addGet('/organization/new', "organization::newOrganizationForm");
$router->addPost('/organization/{orgId}/members/invite', "organization::invite");
$router->addGet('/organization/{orgId}/members/invite/deny', "organization::deny");
$router->addGet('/organization/{orgId}/members/invite/accept', "organization::accept");

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

$router->add('/user/{username}', 'user::profile');

return $router;