<?php
/**
 * swaeg-regger configuration file
 */

return array(
	
	/* Send mail to attendees on registration? */
	'send_register_mail' => false,

	/* SwiftMailer config - you need to change these */
	'mail_host' => 'smtp.server.com',
	'mail_port' => 465,
	'mail_username' => 'myusername',
	'mail_password' => 'somepassword',
	'mail_encryption' => '',
	'mail_auth_mode' => '', 

	/* Mail content config */
	/* Mail subject */
	'mail_content_subject' => 'You have registered succesfully!',
	/* Where is the mail from */
	'mail_content_from' => 'someone@somemail.com',

	/* Add a 'mailing list'-checkbox to the form (true or false without quotes)*/
	'mailing_list' => true,

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
	'limit' => 2

);

