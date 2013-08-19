![image](http://i.imagebanana.com/img/sgfs0rmr/Gits3.jpg)

An easy way to deploy your git repo to an AWS S3 bucket.

## Installation [![Build Status](https://travis-ci.org/schickling/git-s3.png)](https://travis-ci.org/schickling/git-s3) [![Coverage Status](https://coveralls.io/repos/schickling/git-s3/badge.png?branch=master)](https://coveralls.io/r/schickling/git-s3?branch=master)
A [global installation of Composer](https://github.com/schickling/git-s3/blob/master/docs/COMPOSER.md) is needed. git-s3 is also installed globally.
```sh
$ composer global require schickling/git-s3:dev-master
```

## Usage
After the installation your repository is already checked out in the "repo" folder. There you can do whatever you like and commit your changes. Now you can deploy your current commit.

#### Configure
Either run `$ git-s3 config` or edit the `config.yml` file manually

#### Deploy
Simply run `$ git-s3 deploy`

## Features
* Super easy installation and usage
* Uploads or deletes just the files, which have changed
* No extra files in your S3 bucket
* Deploy history

## Comming soon
* composer global installation
* Command to see deploy history
* Brew support
* subfolder as repo
* higher test coverage
* ...

## Support & Contribution
If you have an issue or an idea how to improve this project please open an Issue/Pull Request [here](https://github.com/schickling/git-s3/issues)
