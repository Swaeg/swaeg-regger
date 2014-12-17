<?php

namespace Swaeg\Tests;

class RegistrationTest extends WebTestCase {

	public function testFrontPage() {
		$client = $this->createClient();
		$request = $client->request('GET', '/');

		// Asserts
		$this->assertTrue($client->getResponse()->isOk());
	}	
}
