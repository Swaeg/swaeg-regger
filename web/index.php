<?php
require_once __DIR__.'/../bootstrap/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

// Some constant sql queries
define('COUNT_QUERY', 'SELECT COUNT(*) as count FROM attendees');
define('EMAIL_CHECK', 'SELECT * FROM attendees WHERE email = ?');

function partyHasRoom($app) {
	$res = $app['db']->fetchAssoc(COUNT_QUERY);
	if($res['count'] >= $app['limit']) { 
		return false;
	} else {
		return true;
	}
}

// Form builder function
function getRegisterForm($app) {
	return $app['form.factory']->createBuilder()
		->add('name', 'text', array('constraints' => array(new Assert\NotBlank())))
		->add('email', 'text', array('constraints' => array(new Assert\Email())))
		->getForm();
}

// This route handles the data from the form
$app->post('/tuuppaa', function (Request $request) use($app) {
	if(!partyHasRoom($app)) {
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_posting']));
	}
	$form = getRegisterForm($app);
	$form->handleRequest($request);
	if ($form->isValid()) {
		$data = $form->getData();
		$check = $app['db']->fetchAssoc(EMAIL_CHECK, array($data['email']));
		if($check) {
			return $app['twig']->render('main.twig.html', array('message' => $app['msg_already_registered']));
		}
		$app['db']->insert('attendees', array('name' => $data['name'], 'email' => $data['email']));
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_registration_ok']));
	} else {
		return $app['twig']->render('main.twig.html', array('form' => $form->createView()));
	}
});

// This route is the simple main route, just renders the form
$app->get('/', function (Request $request) use ($app) {
	if(!partyHasRoom($app) && $request->getMethod() === 'GET') {
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_registration_closed']));
	}
	// Fetch form
	$form = getRegisterForm($app);
	$form->handleRequest($request);

	return $app['twig']->render('main.twig.html', array('form' => $form->createView()));
});

$app->run();

// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent
