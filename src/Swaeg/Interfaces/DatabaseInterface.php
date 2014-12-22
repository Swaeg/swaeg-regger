<?php

namespace Swaeg\Interfaces;

interface DatabaseInterface {

	public function initializeDatabase();
	public function dropDatabase();

	public function insertAttendee($data);
	public function fetchAllAttendees();
	public function countAttendees();
	public function checkEmail($email);


}
