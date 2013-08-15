![image](http://i.imagebanana.com/img/sgfs0rmr/Gits3.jpg)

An easy way to deploy your git repo to a AWS S3 bucket.


## Installation [![Build Status](https://travis-ci.org/schickling/git-s3.png)](https://travis-ci.org/schickling/git-s3)
Just clone this repository `git clone https://github.com/schickling/git-s3.git && cd git-s3`  
and run the installation script `./install.sh`

## Usage

After the installation your repository is already checked out in the "repo" folder. There you can do whatever you like and commit your changes. After that you can deploy your current commit.

#### Deploy
Simply run `bin/git-s3 deploy`

#### Configure
Either run `bin/git-s3 config` or edit the `config.yml` file manually

## Features
* Super easy installation and usage
* Uploads or deletes just the files, which have changed in your repository
* Works with any git repository (even local repositories)
* No extra files in your S3 bucket
* Deploy history

## Comming soon
* composer global installation
* Command to see deploy history
* ...

## Support & Contribution
If you have an issue or an idea how to improve this project please open an Issue/Pull Request [here](https://github.com/schickling/git-s3/issues)
