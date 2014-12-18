<?php

namespace Swaeg\Tests;

use Silex\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase {

	public function createApplication() {
		$app = require $this->getApplicationDir() . "/app.php";
		$app['debug'] = true;
		$app['exception_handler']->disable();
		$app['session.test'] = true;
		return $app;
	}

	public function getApplicationDir() {
		return $_SERVER['APP_DIR'];
	}

	public function tearDown() {
		parent::tearDown();
	}

}
