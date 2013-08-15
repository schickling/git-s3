<?php

use GitS3\Console\Application;
use Mockery as m;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
	private $application;
	private $configMock;
	private $historyMock;

	public function setUp()
	{
		$this->configMock = m::mock('GitS3\Wrapper\Config');
		$this->configMock->shouldReceive('getKey')->once()->andReturn('something');
		$this->configMock->shouldReceive('getSecret')->once()->andReturn('something');
		$this->configMock->shouldReceive('getBucket')->once()->andReturn('something');
		$this->configMock->shouldReceive('getPath')->once()->andReturn(__DIR__ . '/resources/testRepo');

		$this->historyMock = m::mock('GitS3\Wrapper\History');

		$this->application = new Application($this->configMock, $this->historyMock);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testGetConfig()
	{
		$this->assertInstanceOf('GitS3\Wrapper\Config', $this->application->getConfig());
		$this->assertEquals($this->configMock, $this->application->getConfig());
	}

	public function testGetRepository()
	{
		$this->assertInstanceOf('GitWrapper\GitWorkingCopy', $this->application->getRepository());
	}

	public function testGetHistory()
	{
		$this->assertInstanceOf('GitS3\Wrapper\History', $this->application->getHistory());
	}

	public function testGetBucket()
	{
		$this->assertInstanceOf('GitS3\Wrapper\Bucket', $this->application->getBucket());
	}

	public function testIsUpToDatePositive()
	{
		$this->historyMock->shouldReceive('getLastHash')->andReturn('843d77526c91e1ed7ab7236568d797a0a267eb40');
		$this->assertTrue($this->application->isUpToDate());
	}

	public function testIsUpToDateNegative()
	{
		$this->historyMock->shouldReceive('getLastHash')->andReturn('843d77526c91e1ed7ab7236568d797a0a267eb41');
		$this->assertFalse($this->application->isUpToDate());
	}
}