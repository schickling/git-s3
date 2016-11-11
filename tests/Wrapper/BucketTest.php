<?php

use GitS3\Wrapper\Bucket;
use GitS3\Wrapper\Config;
use Aws\S3\S3Client;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\InvalidAccessKeyIdException;
use Aws\S3\Exception\AccessDeniedException;
use Aws\Common\Exception\InstanceProfileCredentialsException;
use Symfony\Component\Finder\SplFileInfo as File;

use Mockery;

class BucketTest extends PHPUnit_Framework_TestCase
{
    private $bucket;
    private $s3Mock;
    private $config;
    private $file;

    public function setUp()
    {
        $config = __DIR__ . '/resources/config.yml';
        $this->config = new Config($config);
           
        $this->bucket = new Bucket($this->config->getKey(), $this->config->getSecret(), $this->config->getBucket(), $this->config->getRegion());
        $this->file = new File('something', 'something', 'something');
        $this->s3Mock = Mockery::mock('Aws\S3\S3Client');
        $this->bucket->setClient($this->s3Mock);
    }

    public function tearDown()
    {
        Mockery::close();
    }
    
    public function testUpload()
    {
        $this->s3Mock->shouldReceive('putObject')->once()->andThrow(new InstanceProfileCredentialsException);
        $this->setExpectedException(InvalidAccessKeyIdException::class, "The AWS Access Key Id you provided does not exist in our records.");
        $this->bucket->upload($this->file);

        $this->s3Mock->shouldReceive('putObject')->once()->andThrow(new Aws\S3\Exception\AccessDeniedException);
        $this->setExpectedException(AccessDeniedException::class);
        $this->bucket->upload($this->file);
    }

    public function testDelete()
    {
        $this->s3Mock->shouldReceive('deleteObject')->once()->andThrow(new InstanceProfileCredentialsException);
        $this->setExpectedException(InvalidAccessKeyIdException::class, "The AWS Access Key Id you provided does not exist in our records.");
        $this->bucket->delete('some/mock/path.sh');

        $this->s3Mock->shouldReceive('deleteObject')->once()->andThrow(new Aws\S3\Exception\AccessDeniedException);
        $this->setExpectedException(AccessDeniedException::class);
        $this->bucket->upload($this->file);
    }
}
