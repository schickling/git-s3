<?php namespace GitS3\Wrapper;

use Aws\S3\S3Client;
use Aws\S3\Enum\CannedAcl;
use Symfony\Component\Finder\SplFileInfo as File;

class Bucket
{

	private $client;
	private $name;
	
	public function __construct($key, $secret, $name)
	{
		$this->name = $name;
		$this->client = S3Client::factory(array(
			'key'		=> $key,
			'secret'	=> $secret,
			));
	}

	public function upload(File $file)
	{
		$this->client->putObject(array(
			'Bucket'		=> $this->name,
			'Key'    		=> $file->getRelativePathname(),
			'SourceFile' 	=> $file->getRealpath(),
			'ACL'   		=> CannedAcl::PUBLIC_READ,
			));
	}

	public function delete($fileName)
	{
		$this->client->deleteObject(array(
			'Bucket' => $this->name,
			'Key'    => $fileName,
			));
	}
}