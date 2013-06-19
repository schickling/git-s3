<?php namespace GitS3\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ConfigCommand extends Command
{

	private $input;
	private $output;

	protected function configure()
	{
		$this->setName('config');
		$this->setDescription('Set your AWS Credentials and init your repo');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;
		$this->output = $output;

		$this->configureAWS();
		$this->configureRepo();

		$this->output->writeln('Configuration was successful.');
	}

	private function configureAWS()
	{
		$this->askAndSet('Enter your AWS access key ID: ', 'key', 'key');
		$this->askAndSet('Enter your AWS secret access key: ', 'secret', 'secret');
		$this->askAndSet('Enter your Region name (default: eu-west-1): ', 'region', 'eu-west-1');
		$this->askAndSet('Enter your bucket title: ', 'bucket', 'bucket');
	}

	private function configureRepo()
	{
		// TODO
	}

	private function askAndSet($question, $configKey, $default)
	{
		$application = $this->getApplication();
		$dialog = $application->getHelperSet()->get('dialog');
		$config = $application->getConfig();

		$value = $dialog->ask($this->output, $question, $default);
		$config[$configKey] = $value;

		$application->setConfig($config);
	}
	
}