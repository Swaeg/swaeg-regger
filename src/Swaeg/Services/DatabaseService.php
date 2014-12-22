<?php

namespace Swaeg\Services;

/**
 * DatabaseService class handles all database related queries.
 */
class DatabaseService extends SwaegBaseService {

	protected static $INIT_QUERY = "CREATE TABLE IF NOT EXISTS attendees(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL, mailing_list BOOLEAN, created_at TIMESTAMP DEFAULT (datetime('now','localtime')))";
	protected static $DROP_QUERY = "DROP TABLE IF EXISTS attendees";
	protected static $ATTENDEE_SELECT_QUERY = "SELECT name, email, mailing_list FROM attendees";
	protected static $COUNT_QUERY = 'SELECT COUNT(*) as count FROM attendees';
	protected static $EMAIL_CHECK = 'SELECT * FROM attendees WHERE email = ?';
	
	public function initializeDatabase() {
		return $this->getSilexApplication()['db']->executeQuery(self::$INIT_QUERY);
	}

	public function dropDatabase() {
		return $this->getSilexApplication()['db']->executeQuery(self::$DROP_QUERY);
	}
	
	public function insertAttendee($data) {
		return $this->getSilexApplication()['db']->insert('attendees', array('name' => $data['name'], 'email' => $data['email'], 'mailing_list' => $data['mailing_list']));
	}

	public function fetchAllAttendees() {
		return $this->getSilexApplication()['db']->fetchAll(self::$ATTENDEE_SELECT_QUERY);
	}

	public function countAttendees() {
		return $this->getSilexApplication()['db']->fetchAssoc(self::$COUNT_QUERY);
	}

	public function checkEmail($email) {
		return $this->getSilexApplication()['db']->fetchAssoc(self::$EMAIL_CHECK, array($email));
	}	

}
