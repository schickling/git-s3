<?php

use GitS3\Wrapper\Diff;
use Mockery as m;

class DiffTest extends PHPUnit_Framework_TestCase
{
	public function testFileAdded()
	{
		$output = "A\tnewFile";
		
		$repository = m::mock('GitWrapper\GitWorkingCopy');
		$repository->shouldReceive('diff')->once();
		$repository->shouldReceive('getDirectory')->once()->andReturn('');
		$repository->shouldReceive('run')->once()->andReturn($repository);
		$repository->shouldReceive('getOutput')->once()->andReturn($output);

		$diff = new Diff($repository, 'someHash');

		$expectedFilesToUpload = array(
			'newFile',
			);
		$expectedFilesToDelete = array();

		$this->assertEquals($expectedFilesToUpload, $diff->getFilesToUpload());
		$this->assertEquals($expectedFilesToDelete, $diff->getFilesToDelete());
	}

	public function testFileDeleted()
	{
		$output = "D\tdeletedFile";
		
		$repository = m::mock('GitWrapper\GitWorkingCopy');
		
		$repository->shouldReceive('diff')->once();
		$repository->shouldReceive('getDirectory')->once()->andReturn('');
		$repository->shouldReceive('run')->once()->andReturn($repository);
		$repository->shouldReceive('getOutput')->once()->andReturn($output);

		$diff = new Diff($repository, 'someHash');

		$expectedFilesToUpload = array();
		$expectedFilesToDelete = array(
			'deletedFile',
			);

		$this->assertEquals($expectedFilesToUpload, $diff->getFilesToUpload());
		$this->assertEquals($expectedFilesToDelete, $diff->getFilesToDelete());
	}

	public function testFileModified()
	{
		$output = "M\tmodfiedFile";
		
		$repository = m::mock('GitWrapper\GitWorkingCopy');
		
		$repository->shouldReceive('diff')->once();
		$repository->shouldReceive('getDirectory')->once()->andReturn('');
		$repository->shouldReceive('run')->once()->andReturn($repository);
		$repository->shouldReceive('getOutput')->once()->andReturn($output);

		$diff = new Diff($repository, 'someHash');

		$expectedFilesToUpload = array(
			'modfiedFile',
			);
		$expectedFilesToDelete = array();

		$this->assertEquals($expectedFilesToUpload, $diff->getFilesToUpload());
		$this->assertEquals($expectedFilesToDelete, $diff->getFilesToDelete());
	}

	public function testMultipleFilesAdded()
	{
		$output = "A\tnewFile\nA\tanotherNewFile\nA\tyetAnotherNewFile";
		
		$repository = m::mock('GitWrapper\GitWorkingCopy');
		
		$repository->shouldReceive('diff')->once();
		$repository->shouldReceive('getDirectory')->once()->andReturn('');
		$repository->shouldReceive('run')->once()->andReturn($repository);
		$repository->shouldReceive('getOutput')->once()->andReturn($output);

		$diff = new Diff($repository, 'someHash');

		$expectedFilesToUpload = array(
			'newFile',
			'anotherNewFile',
			'yetAnotherNewFile',
			);
		$expectedFilesToDelete = array();

		$this->assertEquals($expectedFilesToUpload, $diff->getFilesToUpload());
		$this->assertEquals($expectedFilesToDelete, $diff->getFilesToDelete());
	}
}