<?php

$loader = new \Phalcon\Autoload\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->setDirectories([
  $config->application->controllersDir,
  $config->application->modelsDir,
]);

$loader->setNamespaces([
  'App\Services'     => __DIR__ . '/../app/services/',
  'App\Repositories' => __DIR__ . '/../app/repositories/',
  'App\Dto\Request'  => __DIR__ . '/../app/dto/request',
  'App\Dto\Response' => __DIR__ . '/../app/dto/response',
]);

$loader->register();