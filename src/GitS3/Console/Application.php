<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;


class Application extends BaseApplication
{

	private $config;
	
	public function __construct($name, $version)
	{
		parent::__construct($name, $version);

		// load config
		$this->config = Yaml::parse(__DIR__ . '/../../../config.yml');

		// add available commands
		$this->addCommands(array(
			new Commands\DeployCommand()
			));
	}
}