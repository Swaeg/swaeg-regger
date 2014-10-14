<?php

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Classes\Console\Console;

class CsvCommand extends Knp\Command\Command {
	
	protected function configure() {
		$this->setName('csv')->setDescription("Dumps database as a csv-file");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln("It owkrs!");
	}	
}
