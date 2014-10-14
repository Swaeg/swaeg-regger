<?php
require_once __DIR__.'/../vendor/autoload.php';

// Namespaces

use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\Provider\ConsoleServiceProvider;

$app = new Silex\Application();

// Debug mode
$app['debug'] = true;

// Register Twig service provider
$app->register(new Silex\Provider\TwigServiceProvider(),
	array('twig.path' => __DIR__.'/../views',
));
// Register Doctrine db abstraction layer
$app->register(new Silex\Provider\DoctrineServiceProvider(),
	array('db.options' => array(
		'driver'   => 'pdo_sqlite',
		'path'     => __DIR__.'/../db/app.db')
));

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

return $app;