swaeg-regger
============

[!(license)(http://img.shields.io/badge/license-MIT-green.svg?style=flat-square)]

A party attendee registering application for party organizers.
The app is simple one form app where attendees can register their name and email and optionally register to a mailing list.
Organizers can dump the attendees to a csv-file to use in mailchimp etc. 

## Installation
	* Make sure you have php5-sqlite installed on your server (E.g. sudo apt-get install php5-sqlite)
	* Git clone the repository
	* Run the command: php composer.phar install
	* Run the command: ./regger init
	* Make sure your web server can read and write the /db/-directory and the newly created app.db
	* Edit config/config.php and set your invitation limit and other options.
	* Point your web server to web/index.php

## Command line tools

	This application contains some command line tools to help with managing.
	The command line executable is named regger.

	Commands implemented:
	* regger init   
		Creates a new database in the /db-folder. Does create a new one if it exists already -> use reset for this.
	* regger reset
		Drops all tables from the database and creates fresh ones.
	* regger csv
		Dumps the database to a csv-file in the projects root named 'registered.csv'

## Tests

	Run unit tests with 'phpunit'

## FAQ

* The app is not working!? I can't register my name or email?!

Make sure your web server is configured correctly. More info http://silex.sensiolabs.org/doc/web_servers.html
		
