<?php namespace GitS3\Wrapper;

class History
{

	private $hashes = array();
	private $filePath;

	public function __construct($filePath) {
		$this->filePath = $filePath;
		$this->load();
	}

	public function isEmpty()
	{
		return count($this->hashes) === 0;
	}

	public function getHashes()
	{
		return $this->hashes;
	}

	public function getLastHash()
	{
		return $this->hashes[count($this->hashes) - 1];
	}

	public function addHash($hash)
	{
		array_push($this->hashes, $hash);
	}

	public function save()
	{
		$data = implode("\n", $this->hashes);
		file_put_contents($this->filePath, $data);
	}

	private function load()
	{
		if ( ! is_file($this->filePath))
		{
			touch($this->filePath);
		}

		$data = file_get_contents($this->filePath);
		$lines = explode("\n", $data);

		foreach ($lines as $line) {
			if (preg_match('/[a-f0-9]{40}/', $line)) {
				$this->addHash($line);
			}
		}
	}
}