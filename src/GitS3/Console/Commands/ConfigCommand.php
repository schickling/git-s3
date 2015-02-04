<?php namespace GitS3\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Question\Question;

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
		$this->configurePath();
		$this->configureRepo();
		$this->saveConfig();

		$this->output->writeln('Configuration was successful.');
	}

	private function configureAWS()
	{
		$this->askAndSet('Enter your AWS access key ID: ', 'key', 'key');
		$this->askAndSet('Enter your AWS secret access key: ', 'secret', 'secret');
		$this->askAndSet('Enter your Region name (default: eu-west-1): ', 'eu-west-1', 'region');
		$this->askAndSet('Enter your bucket title: ', 'bucket', 'bucket');
	}

	private function configurePath()
	{
		$this->askAndSet('Enter the path (relative or absolute) where your repo lives: ', '', 'path');
	}

	private function configureRepo()
	{
		$question = new Question('Do you want to clone your repo? (default: "n"): ', 'n');
		if (strtolower($this->ask($question, 'n') == 'y'))
		{
			$application = $this->getApplication();
			$config = $application->getConfig();
			$repository = $application->getRepository();
		
			$repoQuestion = new Question('Please enter your repo (SSH/HTTPS/local): ', '');
			$repoName = $this->ask($repoQuestion, '');

			// reset repo folder
			$repoFolder = $config->getPath();
			$fs = new Filesystem();
			$fs->remove($repoFolder);
			$fs->mkdir($repoFolder);

			$repository->clone($repoName);
		}		
	}

	private function saveConfig()
	{
		$application = $this->getApplication();
		$config = $application->getConfig();
		$config->save();
	}

	private function askAndSet($questionString, $defaultValue, $configKey)
	{
		$application = $this->getApplication();
		$config = $application->getConfig();
		$askQuestion = new Question($questionString, $defaultValue);

		$value = $this->ask($askQuestion, $defaultValue);

		$setter = 'set' . ucfirst($configKey);
		$config->$setter($value);
	}

	private function ask($askQuestion, $defaultValue)
	{
		$application = $this->getApplication();
		$question = $application->getHelperSet()->get('question');
		return $question->ask($this->input, $this->output, $askQuestion);
	}
	
}
