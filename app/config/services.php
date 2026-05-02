<?php
declare (strict_types = 1);

use App\Repositories\Interfaces\IInviteRepository;
use App\Repositories\Interfaces\IMembershipRepository;
use App\Repositories\Interfaces\IOrganizationRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\InviteRepository;
use App\Repositories\MembershipRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\MembershipService;
use App\Services\UserService;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Html\Escaper;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
  return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
  $config = $this->getConfig();

  $url = new UrlResolver();
  $url->setBaseUri($config->application->baseUri);

  return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
  $config = $this->getConfig();

  $view = new View();
  $view->setDI($this);
  $view->setViewsDir($config->application->viewsDir);
  $view->setLayout('main');

  $view->registerEngines([
    '.volt'  => function ($view) {
      $config = $this->getConfig();

      $volt = new VoltEngine($view, $this);

      $volt->setOptions([
        'path'      => $config->application->cacheDir,
        'separator' => '_',
        'always'    => true,
        'stat'      => true,
      ]);

      return $volt;
    },
    '.phtml' => PhpEngine::class,

  ]);

  return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
  $config = $this->getConfig();

  $class  = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
  $params = [
    'host'     => $config->database->host,
    'username' => $config->database->username,
    'password' => $config->database->password,
    'dbname'   => $config->database->dbname,
    'schema'   => $config->database->schema,
  ];

  if ($config->database->adapter == 'Postgresql') {
    unset($params['charset']);
  }

  return new $class($params);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
  return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
  $escaper = new Escaper();
  $flash   = new Flash($escaper);
  $flash->setImplicitFlush(false);
  $flash->setCssClasses([
    'error'   => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice'  => 'alert alert-info',
    'warning' => 'alert alert-warning',
  ]);

  return $flash;
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
  $session = new SessionManager();
  $files   = new SessionAdapter([
    'savePath' => sys_get_temp_dir(),
  ]);
  $session->setAdapter($files);
  $session->start();

  return $session;
});

$di->setShared('router', function () {
  return include __DIR__ . '/router.php';
});

$di->setShared(Phalcon\Mvc\Model\Transaction\Manager::class, function () {
  return new Phalcon\Mvc\Model\Transaction\Manager();
});

// Repositories

$di->setShared('userRepository', function () {
  return new UserRepository();
});

$di->setShared(IUserRepository::class, function () use ($di) {
  return $di->get('userRepository');
});

$di->setShared('membershipRepository', function () use ($di) {
  return new MembershipRepository(
    $di->get('modelsManager'));
});

$di->setShared(IMembershipRepository::class, function () use ($di) {
  return $di->get('membershipRepository');
});

$di->setShared(IOrganizationRepository::class, function () use ($di) {
  return new OrganizationRepository(
    $di->get('modelsManager')
  );
});

$di->setShared(IInviteRepository::class, function () use ($di) {
  return new InviteRepository(
    $di->get('modelsManager')
  );
});

// Services

$di->setShared('userService', function () use ($di) {
  return new UserService(
    $di->get(IUserRepository::class),
    $di->get('membershipService')
  );
});

$di->setShared('authService', function () use ($di) {
  return new AuthService(
    $di->get('userService'),
    $di->get('security'),
    $di->get('session')
  );
});

$di->setShared('inviteService', function () use ($di) {
  return new InviteService(
    $di->get(IInviteRepository::class),
    $di->get('membershipService'::class),
    $di->get('userService'),
  );
});

$di->setShared('organizationService', function () use ($di) {
  return new OrganizationService(
    $di->get(IOrganizationRepository::class),
    $di->get('membershipService'::class),
    $di->get('inviteService'),
    $di->get('userService'::class),
  );
});

$di->setShared('membershipService', function () use ($di) {
  return new MembershipService(
    $di->get(IMembershipRepository::class)
  );
});