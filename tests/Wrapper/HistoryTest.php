<?php

use GitS3\Wrapper\History;

class HistoryTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->deleteTestHistory();
	}

	public function testReadHistory()
	{
		$history = new History(__DIR__ . '/resources/readHistory.lock');
		$expectedHashes = array(
			'20d4531193c0d78222152911ad932dc5a6caf320',
			'20d4531193c0d78222152911ad932dc5a6caf321',
			'20d4531193c0d78222152911ad932dc5a6caf322',
			'20d4531193c0d78222152911ad932dc5a6caf323',
			'20d4531193c0d78222152911ad932dc5a6caf324',
			);

		$this->assertEquals($expectedHashes, $history->getHashes());
		$this->assertEquals('20d4531193c0d78222152911ad932dc5a6caf324', $history->getLastHash());
	}

	public function testCreateHistoryFile()
	{
		$history = new History(__DIR__ . '/resources/testHistory.lock');

		$this->assertTrue(is_file(__DIR__ . '/resources/testHistory.lock'));
		$this->assertEquals(array(), $history->getHashes());
	}

	public function testIsEmptyPositive()
	{
		$history = new History(__DIR__ . '/resources/testHistory.lock');
		
		$this->assertTrue($history->isEmpty());
	}

	public function testIsEmptyNegative()
	{
		$history = new History(__DIR__ . '/resources/readHistory.lock');
		
		$this->assertFalse($history->isEmpty());
	}

	public function testAddHash()
	{
		$history = new History(__DIR__ . '/resources/testHistory.lock');
		$history->addHash('20d4531193c0d78222152911ad932dc5a6caf320');
		$history->addHash('20d4531193c0d78222152911ad932dc5a6caf321');

		$expectedHashes = array(
			'20d4531193c0d78222152911ad932dc5a6caf320',
			'20d4531193c0d78222152911ad932dc5a6caf321',
			);

		$this->assertEquals($expectedHashes, $history->getHashes());
		$this->assertEquals('20d4531193c0d78222152911ad932dc5a6caf321', $history->getLastHash());
	}

	public function testHashesGetSaved()
	{
		$history = new History(__DIR__ . '/resources/testHistory.lock');
		$history->addHash('20d4531193c0d78222152911ad932dc5a6caf320');
		$history->save();
		
		$history = new History(__DIR__ . '/resources/testHistory.lock');
		$this->assertEquals(array('20d4531193c0d78222152911ad932dc5a6caf320'), $history->getHashes());
		$this->assertEquals('20d4531193c0d78222152911ad932dc5a6caf320', $history->getLastHash());
	}

	private function deleteTestHistory()
	{
		$filePath = __DIR__ . '/resources/testHistory.lock';
		if (is_file($filePath))
		{
			unlink($filePath);
		}
	}
}