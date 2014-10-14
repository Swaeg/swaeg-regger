<?php

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use League\Csv\Writer;

class CsvCommand extends Knp\Command\Command {
	
	protected function configure() {
		$this->setName('csv')->setDescription("Dumps database as a csv-file");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln("Dumping sql to csv-file");
		$sql = "SELECT name, email FROM attendees";
		$app = $this->getSilexApplication();
		$users = $app['db']->fetchAll($sql);
		$csv = Writer::createFromFileObject(new SplFileObject(__DIR__.'/../registered.csv', 'a+'), 'w');
		$csv->setNullHandlingMode(Writer::NULL_AS_EMPTY);
		$csv->insertOne(['name', 'email']);
		$csv->insertAll($users);
		//$csv->output('registered.csv');
		$output->writeln("Sql dumped. File saved as registered.csv");
	}	
}
