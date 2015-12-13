<?php namespace GitS3\Console;

use Symfony\Component\Console\Application as BaseApplication;
use GitWrapper\GitWrapper;
use GitS3\Wrapper\Bucket;
use GitS3\Wrapper\Config;
use GitS3\Wrapper\History;

class Application extends BaseApplication
{

	private $config;
	private $bucket;
	private $repository;
	private $history;
	
	public function __construct(Config $config, History $history)
	{
		parent::__construct('git-s3', '0.1.0');

		$this->config = $config;
		$this->history = $history;

		$this->addCommands(array(
			new Commands\ConfigCommand(),
			new Commands\DeployCommand(),
			));
	}

	public function getRepository()
	{
		// lazy initialize
		if ( ! $this->repository)
		{
			$this->initRepository();
		}

		return $this->repository;
	}

	public function getBucket()
	{
		// lazy initialize
		if ( ! $this->bucket)
		{
			$this->initBucket();
		}

		return $this->bucket;
	}

	public function getHistory()
	{
		return $this->history;
	}

	public function getConfig()
	{
		return $this->config;
	}

	public function isUpToDate()
	{
		return $this->history->getLastHash() == $this->getCurrentHash();
	}

	public function saveLastDeploy()
	{
		$lastDeploy = $this->getCurrentHash();

		$this->history->addHash($lastDeploy);
		$this->history->save();
	}

	private function getCurrentHash()
	{
		return $this->getRepository()->log('-1', array('pretty' => 'format:%H'))->getOutput();
	}

	private function initBucket()
	{
		$this->bucket = new Bucket($this->config->getKey(), $this->config->getSecret(), $this->config->getBucket(), $this->config->getRegion());
	}

	private function initRepository()
	{
		$gitWrapper = new GitWrapper();
		$this->repository = $gitWrapper->workingCopy($this->config->getPath());
	}
}