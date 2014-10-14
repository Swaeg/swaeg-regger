<?php
require_once __DIR__.'/../vendor/autoload.php';

// Namespaces
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;

// Some constant sql queries
define('COUNT_QUERY', 'SELECT COUNT(*) as count FROM attendees');

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

// Form builder function
function getRegisterForm($app) {
	return $app['form.factory']->createBuilder()
		->add('name', 'text', array('constraints' => array(new Assert\NotBlank())))
		->add('email', 'text', array('constraints' => array(new Assert\Email())))
		->getForm();
}

// This route handles the data from the form
$app->post('/tuuppaa', function (Request $request) use($app) {
	$form = getRegisterForm($app);
	$form->handleRequest($request);
	if ($form->isValid()) {
		$data = $form->getData();
		$app['db']->insert('attendees', array('name' => $data['name'], 'email' => $data['email']));
	}
});

// This route is the simple main route, just renders the form
$app->get('/', function (Request $request) use ($app) {
	$res = $app['db']->fetchAssoc(COUNT_QUERY);
	if($res['count'] >= 300) {
		// return something or redirect etc.
		return "No bonus";
	}
	// Fetch form
	$form = getRegisterForm($app);
	$form->handleRequest($request);

	return $app['twig']->render('main.twig.html', array('form' => $form->createView()));
});


/*$app->get('/init-db', function() use($app) {
	$sql = "CREATE TABLE IF NOT EXISTS attendees(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL)";
	$app['db']->executeQuery($sql);
	return "Init db!";
});*/

$app->run();


// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
