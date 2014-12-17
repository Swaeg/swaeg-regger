<?php
require_once __DIR__.'/../vendor/autoload.php';
// Namespaces

use Silex\Provider\FormServiceProvider;
use Knp\Provider\ConsoleServiceProvider;

$app = new Silex\Application();

// Debug mode
$app['debug'] = false;

// Register Doctrine db abstraction layer
$app->register(new Silex\Provider\DoctrineServiceProvider(),
	array('db.options' => array(
		'driver'   => 'pdo_sqlite',
		'path'     => __DIR__.'/../db/app.db')
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
	'translator.domains' => array(),
));
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/config.php"));
$app->register(new ConsoleServiceProvider(), array(
	'console.name' => 'SWGRGR',
	'console.version' => '0.1.0',
        'console.project_directory' => __DIR__."/..",
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => __DIR__.'/../app.log',
	'monolog.level' => Monolog\Logger::NOTICE,
));

// Register Twig service provider
$app->register(new Silex\Provider\TwigServiceProvider(),
	array('twig.path' => __DIR__.'/../views',
));


return $app;
