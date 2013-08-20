![image](http://i.imagebanana.com/img/sgfs0rmr/Gits3.jpg)

An easy way to deploy your git repo to an AWS S3 bucket.

## Installation [![Build Status](https://travis-ci.org/schickling/git-s3.png)](https://travis-ci.org/schickling/git-s3) [![Coverage Status](https://coveralls.io/repos/schickling/git-s3/badge.png?branch=master)](https://coveralls.io/r/schickling/git-s3?branch=master)
A [global installation of Composer](https://github.com/schickling/git-s3/blob/master/doc/COMPOSER.md) is needed. __git-s3 is installed globally.__
```sh
$ composer global require schickling/git-s3:dev-master
```

## Usage
After the installation run `git-s3 config` to initialize the app.  All needed files (config, history) will be created in the current directory. That's it. [A full example can be found here.](https://github.com/schickling/git-s3/blob/master/doc/EXAMPLE.md)

#### Configure / Initialize
Edit the `config.yml` file manually or run
```sh
$ git-s3 config
```

#### Deploy
```sh
$ git-s3 deploy
```

## Features
* Super easy installation and usage
* Uploads or deletes just the files, which have changed
* No extra files in your S3 bucket
* Deploy history

## Comming soon
* Command to see deploy history
* Brew support
* subfolder as repo
* higher test coverage
* upload progress bar
* ...

## Support & Contribution
If you have an issue or an idea how to improve this project please open an Issue/Pull Request [here](https://github.com/schickling/git-s3/issues)
