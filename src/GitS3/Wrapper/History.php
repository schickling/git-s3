<?php namespace GitS3\Wrapper;

class History
{

	private $hashes = array();
	private $filePath;

	public function __construct($filePath) {
		$this->filePath = $filePath;
		$this->load();
	}

	public function getHashes()
	{
		return $this->hashes;
	}

	public function getCurrentHash()
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
		$data = file_get_contents($this->filePath);
		$this->hashes = explode("\n", $data);
	}
}