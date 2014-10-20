<?php

namespace Commands;

use Knp\Command\Command as Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class ResetCommand extends Command {
	
	protected function configure() {
		$this->setName('reset')->setDescription("Resets the database");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		$helper = $this->getHelper('question');
		$question = new ConfirmationQuestion('Are you 100% sure you want to reset all data? (y/n) ', false);
		if (!$helper->ask($input, $output, $question)) {
	    		return;
		}
		$app = $this->getSilexApplication();
		$deleteSql = "DROP TABLE IF EXISTS attendees";
		$app['db']->executeQuery($deleteSql);
		$output->writeln('Old database dropped.');
		$createSql = "CREATE TABLE IF NOT EXISTS attendees(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL)";
		$app['db']->executeQuery($createSql);
		$output->writeln('New database created.');
		$output->writeln('== DONE ==');
	}	
}
