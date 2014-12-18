<?php

namespace Swaeg\Tests;

class RegistrationTest extends WebTestCase {

	public function testFrontPage() {
		$client = $this->createClient();
		$crawler = $client->request('GET', '/');
		// Asserts
		$this->assertTrue($client->getResponse()->isOk());
		$this->assertCount(1, $crawler->filter('form'));
		$this->assertCount(1, $crawler->filter('#form_name'));
		$this->assertCount(1, $crawler->filter('#form_email'));
		$this->assertCount(1, $crawler->filter('input[type=submit]'));
	}

	public function testFormSubmit() {
		$client = $this->createClient();
		$crawler = $client->request('GET', '/');
		
		$form = $crawler->selectButton('submit')->form();
		
		$form['form[name]'] = 'Testo Manno';
		$form['form[email]'] = 'testo@testo.com';

		$crawler = $client->submit($form);
		$this->assertGreaterThan(0, $crawler->filter('h1')->count());
	}
}
