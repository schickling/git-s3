<?php namespace GitS3\Wrapper;

use GitWrapper\GitWorkingCopy as Repository;

class Diff
{
	private $filesToUpload = array();
	private $filesToDelete = array();
	private $repository;
	private $hashToCompare;
	
	public function __construct(Repository $repository, $hashToCompare)
	{
		$this->repository = $repository;
		$this->hashToCompare = $hashToCompare;
		$this->prepare();
	}

	private function prepare()
	{
		$this->repository->diff($this->hashToCompare, array('name-status' => true));
		$this->processOutput($this->repository->getOutput());
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

		$repositoryRoot = trim($this->repository->run(array('rev-parse --show-toplevel'))->getOutput());
		$repositorySubfolder = $this->repository->getDirectory();
		$subFolder = str_replace($repositoryRoot . '/', '', $repositorySubfolder);

		foreach ($lines as $line) {
			list($action, $fileName) = explode("\t", $line);

			// make file path relative to subdir
			$fileName = str_replace($subFolder . '/', '', $fileName);

			if ($action == 'D') {
				array_push($this->filesToDelete, $fileName);
			} else {
				array_push($this->filesToUpload, $fileName);
			}
		}
	}
}
