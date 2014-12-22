<?php

namespace Swaeg\Commands;

use Knp\Command\Command as Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use League\Csv\Writer;

class CsvCommand extends Command {

	const SQL = "SELECT name, email, mailing_list FROM attendees";
	
	protected function configure() {
		$this->setName('csv')->setDescription("Dumps database as a csv-file");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln("Dumping sql to csv-file");
		$app = $this->getSilexApplication();
		$users = $app['db_service']->fetchAllAttendees();
		if (file_exists(__DIR__.'/../../../registered.csv')) {
			unlink(__DIR__.'/../../../registered.csv');
		}
		$csv = Writer::createFromFileObject(new \SplFileObject(__DIR__.'/../../../registered.csv', 'a+'), 'w');
		$csv->setNullHandlingMode(Writer::NULL_AS_EMPTY);
		$csv->insertOne(['name', 'email', 'mailing_list']);
		$csv->insertAll($users);
		$output->writeln("Sql dumped. File saved as registered.csv");
	}	
}
