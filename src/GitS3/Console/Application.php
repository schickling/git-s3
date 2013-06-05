<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;
use Gitonomy\Git\Repository;
use GitS3\Wrapper\Bucket;


class Application extends BaseApplication
{

	private $config;
	private $repository;
	private $bucket;
	
	public function __construct($name, $version)
	{
		parent::__construct($name, $version);

		// prepare bucket
		$config = Yaml::parse(__DIR__ . '/../../../config.yml');
		$this->bucket = new Bucket($config['key'], $config['secret'], $config['bucket']);

		// load repository
		$this->repository = new Repository(__DIR__ . '/../../../repo');

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

	public function getBucket()
	{
		return $this->bucket;
	}

	public function getRepositoryPath()
	{
		return $this->repository->getPath();
	}

	public function writeLastDeploy()
	{
		$hash = $this->repository->run('rev-parse', array('HEAD'));

		file_put_contents(__DIR__ . '/../../../last-deploy.lock', $hash);
	}
}