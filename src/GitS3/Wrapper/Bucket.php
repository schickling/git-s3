<?php namespace GitS3\Wrapper;

use Aws\S3\S3Client;
use Aws\S3\Enum\CannedAcl;
use Symfony\Component\Finder\SplFileInfo as File;

class Bucket
{

	private $s3;
	private $name;
	
	public function __construct($key, $secret, $name)
	{
		$this->s3 = S3Client::factory(array(
			'key'		=> $key,
			'secret'	=> $secret
			));
		$this->name = $name;
	}

	public function upload(File $file)
	{
		$key = $file->getRelativePathname();

		$this->s3->putObject(array(
			'Bucket' => $this->name,
			'Key'    => $file->getRelativePathname(),
			'Body'   => fopen($file->getRealpath(), 'r'),
			'ACL'    => CannedAcl::PUBLIC_READ
			));
	}

	public function delete(File $file)
	{
		$this->s3->deleteObject(array(
			'Bucket' => $this->name,
			'Key'    => $file->getRelativePathname()
			));
	}
}