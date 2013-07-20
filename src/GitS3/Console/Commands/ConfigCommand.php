<?php namespace GitS3\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

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
		$this->askAndSet('Enter your Region name (default: eu-west-1): ', 'eu-west-1', 'region');
		$this->askAndSet('Enter your bucket title: ', 'bucket', 'bucket');
	}

	private function configureRepo()
	{
		$application = $this->getApplication();
		$repository = $application->getRepository();

		$repoName = $this->ask('Please enter your repo (SSH/HTTPS/local): ', '');

		// reset repo folder
		$repoFolder = $application->getConfig()->getPath();
		$fs = new Filesystem();
		$fs->remove($repoFolder);
		$fs->mkdir($repoFolder);

		$repository->clone($repoName);
	}

	private function askAndSet($question, $defaultValue, $configKey)
	{
		$application = $this->getApplication();
		$config = $application->getConfig();

		$value = $this->ask($question, $defaultValue);
		$config[$configKey] = $value;

		$application->setConfig($config);
	}

	private function ask($question, $defaultValue)
	{
		$application = $this->getApplication();
		$dialog = $application->getHelperSet()->get('dialog');

		return $dialog->ask($this->output, $question, $defaultValue);
	}
	
}