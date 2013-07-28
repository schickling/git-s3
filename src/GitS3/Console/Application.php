<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use GitWrapper\GitWrapper;
use GitS3\Wrapper\Bucket;
use GitS3\Wrapper\Config;

class Application extends BaseApplication
{

	private $config;
	private $bucket;
	private $repository;
	
	public function __construct(Config $config)
	{
		parent::__construct('git-s3', '0.1.0');

		$this->config = $config;

		$this->initBucket();
		$this->initRepository();
		$this->initCommands();
	}

	private function initBucket()
	{
		$this->bucket = new Bucket($this->config->getKey(), $this->config->getSecret(), $this->config->getBucket());
	}

	private function initRepository()
	{
		$wrapper = new GitWrapper();
		$this->repository = $wrapper->workingCopy($this->config->getPath());
	}

	private function initCommands()
	{
		$this->addCommands(array(
			new Commands\ConfigCommand(),
			new Commands\DeployCommand(),
			));
	}

	public function getRepository()
	{
		return $this->repository;
	}

	public function getBucket()
	{
		return $this->bucket;
	}

	public function getConfig()
	{
		return $this->config;
	}

	public function getHashOfLastDeploy()
	{
		$this->checkLastDeployLockFile();
		return trim(file_get_contents(__DIR__ . '/../../../last-deploy.lock'));
	}

	public function writeLastDeploy()
	{
		$this->checkLastDeployLockFile();
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

	private function checkLastDeployLockFile()
	{
		if ( ! is_file(__DIR__ . '/../../../last-deploy.lock'))
		{
			touch(__DIR__ . '/../../../last-deploy.lock');
		}
	}
}