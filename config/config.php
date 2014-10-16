<?php
/**
 * swaeg-regger configuration file
 */

return array(

	/* Some messages returned to the user */
	/* This error message is displayed when some fancy pants is trying to manually post to our posting url and the registration is closed. */
	'msg_posting' => "NOPE!",

	/* This message is shown when the user is trying to register again with the same email */
	'msg_already_registered' => "You have already registered",

	/* This message is shown when registration is ok */
	'msg_registration_ok' => "REGISTRATION OK!",

	/* This message is shown when registration is closed -> limit has been reached */
	'msg_registration_closed' => "Registration has closed",

	/* Here you can change the number of attendees. You can change this number whenever you like. */
	'limit' => 300

);

