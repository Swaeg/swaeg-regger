<?php

namespace Swaeg\Services;

use Silex\Application;

class ConstraintService {

	protected static $COUNT_QUERY = 'SELECT COUNT(*) as count FROM attendees';
	protected static $EMAIL_CHECK = 'SELECT * FROM attendees WHERE email = ?';

	public function partyHasRoom(Application $app) {
		$res = $app['db']->fetchAssoc(self::$COUNT_QUERY);
		if($res['count'] >= $app['limit']) {
			return false;
		} else {
			return true;
		}
	}

	public function hasRegistered(Application $app, $email) {
		$check = $app['db']->fetchAssoc(self::$EMAIL_CHECK, array($email));
		if($check) {
			return true;
		} else {
			return false;
		}
	}
}
