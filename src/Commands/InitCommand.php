<?php

namespace Commands;

use Knp\Command\Command as Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class InitCommand extends Command {
	
	protected function configure() {
		$this->setName('init')->setDescription("Initializes an empty database");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		$app = $this->getSilexApplication();
        	$sql = "CREATE TABLE IF NOT EXISTS attendees(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL)";
		$app['db']->executeQuery($sql);
		$output->writeln('New database created.');
		chmod(__DIR__.'/../db/app.db', 0777);
		$output->writeln('== DONE ==');
	}	
}
