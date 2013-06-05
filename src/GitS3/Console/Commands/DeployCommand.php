<?php namespace GitS3\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class DeployCommand extends Command {

	private $output;
	private $finder;

	protected function configure() {
		$this->setName('deploy');
		$this->setDescription('Deploy the current git repo');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$application = $this->getApplication();

		$this->output = $output;
		$this->bucket = $application->getBucket();
		$this->finder = new Finder();
		$this->finder->files()->in($application->getRepositoryPath());

		if ($this->hasNotBeenInitialized()) {
			$this->init();
		} else {
			$this->deployCurrentCommit();
		}

		$application->writeLastDeploy();
		$output->writeln('Lock file updated. Deployment complete!');

	}

	private function hasNotBeenInitialized()
	{
		return $this->getApplication()->getLastDeploy() == '';
	}

	private function init()
	{
		foreach ($this->finder as $file) {
			$this->uploadFile($file);
		}
	}

	private function deployCurrentCommit()
	{
		$addedSinceLastDeploy = array();
		$deletedSinceLastDeploy = array();

		foreach ($this->finder as $file) {
			if (in_array($file->getRelativePathname(), $addedSinceLastDeploy)) {
				$this->uploadFile($file);
			} elseif (in_array($file->getRelativePathname(), $deletedSinceLastDeploy)) {
				$this->deleteFile($file);
			}
		}
	}

	private function uploadFile($file)
	{
		$this->output->writeln('Uploading ' . $file->getRelativePathname());
		$this->bucket->upload($file);
	}

	private function deleteFile($file)
	{
		$this->output->writeln('Deleting ' . $file->getRelativePathname());
		$this->bucket->delete($file);
	}
}