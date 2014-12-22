<?php

namespace Swaeg\Services;

class ConstraintService extends SwaegBaseService {

	public function partyHasRoom() {
		$res = $this->getSilexApplication()['db_service']->countAttendees();
		if($res['count'] >= $this->getSilexApplication()['limit']) {
			return false;
		} else {
			return true;
		}
	}

	public function hasRegistered($email) {
		$check = $this->getSilexApplication()['db_service']->checkEmail($email);
		if($check) {
			return true;
		} else {
			return false;
		}
	}
}
