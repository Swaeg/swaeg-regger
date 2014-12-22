<?php

namespace Swaeg\Services;

use Symfony\Component\Validator\Constraints as Assert;

class FormGeneratorService extends SwaegBaseService {
	
	// Form builder function
	public function getRegisterForm() {
		$form = $this->getSilexApplication()['form.factory']->createBuilder()
		->add('name', 'text', array('constraints' => array(new Assert\NotBlank())))
		->add('email', 'text', array('constraints' => array(new Assert\Email())));
		// Add extra checkbox if config says so
		if($this->getSilexApplication()['mailing_list']) {
			$form->add('mailing_list', 'checkbox', array('label' => 'Subscribe to newsletter?',
				'required' => false));
		}
		return $form->getForm();
	}

}
