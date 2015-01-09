<?php
require_once __DIR__.'/../vendor/autoload.php';
// Namespaces

use Silex\Provider\FormServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Swaeg\Services\FormGeneratorService;
use Swaeg\Services\ConstraintService;
use Swaeg\Services\DatabaseService;
use Swaeg\Services\MailService;

$app = new Silex\Application();

// Debug mode
$app['debug'] = true;

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
// Swiftmailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

$app['swiftmailer.options'] = array(
	'host' => $app['mail_host'],
	'port' => $app['mail_port'],
	'username' => $app['mail_username'],
	'password' => $app['mail_password'],
	'encryption' => $app['mail_encryption'],
	'auth_mode' => $app['mail_auth_mode']
);

// Swaeg form generator service
$app['form_generator'] = $app->share(function() use($app) {
	return new FormGeneratorService($app);
});
// Constraints service
$app['constraints'] = $app->share(function() use($app) {
	return new ConstraintService($app);
});
// DB queries etc.
$app['db_service'] = $app->share(function() use($app) {
	return new DatabaseService($app);
});
// Swaeg mail service
$app['mail_service'] = $app->share(function() use($app) {
	return new MailService($app);
});

// Init database if we use a in-memory sqlite db for testing
if($app['env'] === 'test') { 
	$app['db_service']->initializeDatabase();
}

return $app;
