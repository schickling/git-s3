<?php

use GitS3\Wrapper\History;

class HistoryTest extends PHPUnit_Framework_TestCase
{
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
		$this->assertEquals('20d4531193c0d78222152911ad932dc5a6caf324', $history->getCurrentHash());
	}
}