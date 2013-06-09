<?php namespace GitS3\Wrapper;

use GitWrapper\GitWorkingCopy as Repository;

class Diff
{
	private $filesToUpload = array();
	private $filesToDelete = array();
	
	public function __construct(Repository $repository, $hashToCompare)
	{
		$output = $repository->diff($hashToCompare, array('name-status' => true))->getOutput();
		$this->processOutput($output);
	}

	public function getFilesToUpload()
	{
		return $this->filesToUpload;
	}

	public function getFilesToDelete()
	{
		return $this->filesToDelete;
	}

	private function processOutput($output)
	{
		$output = trim($output);
		$lines = explode("\n", $output);

		foreach ($lines as $line) {
			list($action, $fileName) = explode("\t", $line);

			if ($action == 'D') {
				array_push($this->filesToDelete, $fileName);
			} else {
				array_push($this->filesToUpload, $fileName);
			}
		}
	}
}