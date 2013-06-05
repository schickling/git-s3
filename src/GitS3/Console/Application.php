<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;
use Gitonomy\Git\Repository;
use Aws\S3\S3Client;


class Application extends BaseApplication
{

	private $config;
	private $repository;
	private $s3;
	
	public function __construct($name, $version)
	{
		parent::__construct($name, $version);

		// prepare s3 client
		$config = Yaml::parse(__DIR__ . '/../../../config.yml');
		$this->s3 = S3Client::factory($config);

		// load repository
		$this->repository = new Repository(__DIR__ . '/../../../');

		// add available commands
		$this->addCommands(array(
			new Commands\DeployCommand()
			));
	}

	public function getLastDeploy()
	{
		return file_get_contents(__DIR__ . '/../../../last-deploy.lock');
	}

	public function getRepository()
	{
		return $this->repository;
	}

	public function getS3()
	{
		return $this->s3;
	}
}