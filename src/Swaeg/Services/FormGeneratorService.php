<?php

namespace Swaeg\Services;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;

class FormGeneratorService {
	
	// Form builder function
	public function getRegisterForm(Application $app) {
		$form = $app['form.factory']->createBuilder()
		->add('name', 'text', array('constraints' => array(new Assert\NotBlank())))
		->add('email', 'text', array('constraints' => array(new Assert\Email())));
		// Add extra checkbox if config says so
		if($app['mailing_list']) {
			$form->add('mailing_list', 'checkbox', array('label' => 'Subscribe to newsletter?',
				'required' => false));
		}
		return $form->getForm();
	}

}
