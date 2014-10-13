<?php
require_once __DIR__.'/../vendor/autoload.php';

// Namespaces
use Silex\Provider\FormServiceProvider;


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

// This route handles the data from the form
$app->post('/tuuppaa', function (Request $request) use($app) {

});

// This route is the simple main route, just renders the form
$app->get('/', function () use ($app) {
    return $app['twig']->render('main.twig');
});


/*$app->get('/init-db', function() use($app) {
	$sql = "CREATE TABLE IF NOT EXISTS attendees(id INT PRIMARY KEY NOT NULL, name TEXT NOT NULL, email TEXT NOT NULL)";
	$app['db']->executeQuery($sql);
	return "Init db!";
});*/

$app->run();


// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
