<?php

use GitS3\Console\Commands\ConfigCommand;
use Symfony\Component\Console\Tester\CommandTester;
use GitS3\Console\Application;
use Mockery as m;

class ConfigCommandTest extends PHPUnit_Framework_TestCase
{
    private $tester;

    public function setUp()
    {
		$configMock = m::mock('GitS3\Wrapper\Config');
        $configMock->shouldReceive('setKey')->once();
		$configMock->shouldReceive('setSecret')->once();
        $configMock->shouldReceive('setPath')->once();
        $configMock->shouldReceive('setRegion')->once();
        $configMock->shouldReceive('setBucket')->once();
        $configMock->shouldReceive('save')->once();

        $historyMock = m::mock('GitS3\Wrapper\History');

		$application = new Application($configMock, $historyMock);

        $dialog = m::mock('Symfony\Component\Console\Helper\QuestionHelper')->makePartial();
        $dialog->shouldReceive('ask');

        $command = new ConfigCommand();
        $command->setApplication($application);
        $command->getHelperSet()->set($dialog, 'dialog');

        $this->tester = new CommandTester($command);
    }

    public function tearDown()
    {
        m::close();
    }

	public function testCommand()
	{
        // TODO make more interactive
        $this->tester->execute(array('command' => 'config'));

        $this->assertRegExp("/^Configuration was successful.$/", $this->tester->getDisplay());
	}
}
