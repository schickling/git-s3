<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;
use GitWrapper\GitWrapper;
use GitS3\Wrapper\Bucket;


class Application extends BaseApplication
{

	private $bucket;
	private $repository;
	
	public function __construct($name, $version)
	{
		parent::__construct($name, $version);

		// prepare bucket
		$config = Yaml::parse(__DIR__ . '/../../../config.yml');
		$this->bucket = new Bucket($config['key'], $config['secret'], $config['bucket']);

		// load repository
		$wrapper = new GitWrapper();
		$this->repository = $wrapper->workingCopy($this->getRepositoryPath());

		// add available commands
		$this->addCommands(array(
			new Commands\DeployCommand()
			));
	}

	public function getHashOfLastDeploy()
	{
		return trim(file_get_contents(__DIR__ . '/../../../last-deploy.lock'));
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
		return __DIR__ . '/../../../repo';
	}

	public function writeLastDeploy()
	{
		file_put_contents(__DIR__ . '/../../../last-deploy.lock', $this->getCurrentHash());
	}

	public function getCurrentHash()
	{
		return $this->repository->log('-1', array('pretty' => 'format:%H'))->getOutput();
	}

	public function getIsUpToDate()
	{
		return $this->getHashOfLastDeploy() == $this->getCurrentHash();
	}
}