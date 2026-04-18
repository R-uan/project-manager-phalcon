<?php

$router = $di->getRouter();

// Define your routes here

$router->addGet('/api/v1/users', [
  'controller' => 'users',
  'action'     => 'index',
]);

$router->addGet('/auth/login', 'Auth::login');
$router->addPost('/auth/login', 'Auth::login');
$router->addGet('/auth/register', 'Auth::register');
$router->addPost('/auth/register', 'Auth::register');
$router->addGet('/auth/logout', 'Auth::logout');

$router->addGet('/organization', 'Organization::index');
$router->addGet('/organization/create', 'Organization::create');
$router->addPost('/organization/create', 'Organization::create');

$router->addGet('/', 'Index::index');

$router->handle($_SERVER['REQUEST_URI']);