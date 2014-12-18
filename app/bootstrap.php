<?php
require_once __DIR__.'/../vendor/autoload.php';
// Namespaces

use Silex\Provider\FormServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Swaeg\Services\FormGeneratorService;
use Swaeg\Services\ConstraintService;

$app = new Silex\Application();

// Debug mode
$app['debug'] = false;

// Environment variable
$app['env'] = isset($_ENV['env']) ? $_ENV['env'] : 'dev';


// Register Doctrine db abstraction layer
if($app['env'] !== 'test') {
	$app->register(new Silex\Provider\DoctrineServiceProvider(),
		array('db.options' => array(
			'driver'   => 'pdo_sqlite',
			'path'     => __DIR__.'/../db/app.db')
	));
} else {
	// Use in-memory sqlite for testing
	$app->register(new Silex\Provider\DoctrineServiceProvider(),
		array('db.options' => array(
			'driver' => 'pdo_sqlite',
			'memory' => true)
	));
	$app['db']->executeQuery("CREATE TABLE IF NOT EXISTS attendees(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL, mailing_list BOOLEAN)");
}

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

// Swaeg form generator service
$app['form_generator'] = $app->share(function() {
	return new FormGeneratorService();
});
// Constraints service
$app['constraints'] = $app->share(function() {
	return new ConstraintService();
});

return $app;
