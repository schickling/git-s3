<?php

use GitS3\Console\Application;
use Mockery as m;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
	private $configMock;
	private $application;

	public function setUp()
	{
		$this->configMock = m::mock('GitS3\Wrapper\Config');
		$this->configMock->shouldReceive('getKey')->once()->andReturn('something');
		$this->configMock->shouldReceive('getSecret')->once()->andReturn('something');
		$this->configMock->shouldReceive('getBucket')->once()->andReturn('something');
		$this->configMock->shouldReceive('getPath')->once()->andReturn('something');

		$this->application = new Application($this->configMock);
	}

	public function testGetConfig()
	{
		$this->assertEquals($this->configMock, $this->application->getConfig());
	}

	public function testGetRepository()
	{
		$this->assertInstanceOf('GitWrapper\GitWorkingCopy', $this->application->getRepository());
	}

	public function testGetBucket()
	{
		$this->assertInstanceOf('GitS3\Wrapper\Bucket', $this->application->getBucket());
	}
}