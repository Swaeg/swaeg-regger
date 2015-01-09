<?php
require __DIR__.'/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;

$app->get('/push', function(Request $request) use($app) {
	return $app->redirect('/');
});

// This route handles the data from the form
$app->post('/push', function (Request $request) use($app) {
	if(!$app['constraints']->partyHasRoom()) {
		$app['monolog']->addWarning(sprintf("Client from ip: %s trying to post when registration is closed!", $request->getClientIp()));
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_posting']));
	}
	$form = $app['form_generator']->getRegisterForm();
	$form->handleRequest($request);
	if ($form->isValid()) {
		$data = $form->getData();
		$check = $app['constraints']->hasRegistered($data['email']);
		if($check) {
			$app['monolog']->addWarning(sprintf("User with email %s trying to register again. This is pretty normal behaviour.", $data['email']));
			return $app['twig']->render('main.twig.html', array('message' => $app['msg_already_registered']));
		}
		if($app['mailing_list']) {
			if(!$data['mailing_list']) {
				$data['mailing_list'] = 0;
			}
		} else {
			$data['mailing_list'] = 0;
		}
		$app['db_service']->insertAttendee($data);
		$app['mail_service']->sendConfirmationMail($data);
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_registration_ok']));
	} else {
		return $app['twig']->render('main.twig.html', array('form' => $form->createView()));
	}
});

// This route is the simple main route, just renders the form
$app->get('/', function (Request $request) use ($app) {
	if(!$app['constraints']->partyHasRoom()) {
		return $app['twig']->render('main.twig.html', array('message' => $app['msg_registration_closed']));
	}
	// Fetch form
	$form = $app['form_generator']->getRegisterForm();
	$form->handleRequest($request);

	return $app['twig']->render('main.twig.html', array('form' => $form->createView()));
});

return $app;

// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent
