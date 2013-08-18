<?php

use GitS3\Wrapper\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
	private $config;

	public function setUp()
	{
		$originalConfigFile = __DIR__ . '/resources/config.yml';
		$copiedConfigFile = __DIR__ . '/resources/copiedConfig.yml';
		copy($originalConfigFile, $copiedConfigFile);

		$this->config = new Config($copiedConfigFile);
	}

	public function testCopyConfigFileOnInit()
	{
		$config = new Config(__DIR__ . '/resources/initConfig.yml');
		
		$this->assertTrue(is_file(__DIR__ . '/resources/initConfig.yml'));
	}

	public function testGetKey()
	{
		$this->assertEquals('YourKey', $this->config->getKey());
	}

	public function testGetSecret()
	{
		$this->assertEquals('YourSecret', $this->config->getSecret());
	}

	public function testGetRegion()
	{
		$this->assertEquals('eu-west-1', $this->config->getRegion());
	}

	public function testGetBucket()
	{
		$this->assertEquals('YourBucket', $this->config->getBucket());
	}

	public function testGetRelativePath()
	{
		$expectedPath = realpath(__DIR__ . '/../../src');
		$this->assertEquals($expectedPath, $this->config->getPath());
	}

	public function testGetAbsolutePath($value='')
	{
		$absolutePath = realpath(__DIR__ . '/../../src');
		$this->config->setPath($absolutePath);
		$this->assertEquals($absolutePath, $this->config->getPath());
	}

	public function testInvalidPath()
	{
		$this->setExpectedException('Exception');
		$this->config->setPath('justWrong');
	}

	public function testSetKey()
	{
		$this->config->setKey('something');
	}

	public function testSetSecret()
	{
		$this->config->setSecret('something');
	}

	public function testSetRegion()
	{
		$this->config->setRegion('something');
	}

	public function testSetBucket()
	{
		$this->config->setBucket('something');
	}

	public function testSetPath()
	{
		$this->config->setPath('./src');
	}

	public function testSetAndSave()
	{
		$this->config->setKey('ChangedKey');
		$this->config->setSecret('ChangedSecret');
		$this->config->setRegion('ChangedRegion');
		$this->config->setBucket('ChangedBucket');
		$this->config->setPath('./bin');

		$this->assertTrue($this->config->save() != false);

		$expectedHash = md5_file(__DIR__ . '/resources/changedConfig.yml');
		$resultHash = md5_file(__DIR__ . '/resources/copiedConfig.yml');

		$this->assertEquals($expectedHash, $resultHash);
	}
}