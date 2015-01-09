<?php
namespace Swaeg\Services;

class MailService extends SwaegBaseService {

	public function sendConfirmationMail($data) {
		$app = $this->getSilexApplication();
		$app['mailer']->send(
			\Swift_Message::newInstance()
			->setSubject($app['mail_content_subject'])
			->setFrom(array($app['mail_content_from']))
			->setTo(array($data['email']))
			->setBody(
				$app['twig']->render('email.twig.html', array('name' => $data['name'])), 
				'text/html')
		);
	}

}
