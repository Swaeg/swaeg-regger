swaeg-regger
============

Party-goers registering application

## Installation
	* Make sure you have php5-sqlite installed on your server (E.g. sudo apt-get install php5-sqlite)
	* Git clone the repository
	* Run the command: php composer.phar install
	* Run the command: ./regger init

## Command line tools

	This application contains some command line tools to help with managing.
	The command line executable is named regger.

	Commands implemented:
	* regger init   
		Creates a new database in the /db-folder
	* regger reset
		Drops all tables from the database and creates fresh ones.
	* regger csv
		Dumps the database to a csv-file inthe projects root named 'registered.csv'


