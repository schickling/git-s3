git-s3
======

Easy way to deploy your git repo to a AWS S3 bucket.


## Install
1. clone this repository
2. run `composer install`
3. clone your own repository you'd like to deploy in the folder "repo"
4. run `./git-s3 config`

## Usage
```
./git-s3 deploy
```
Nothing more. Cool, huh?

## Todo/Ideas
* Commands
    * set commit
    * rollback
    * log
* rename mechanism instead of symbolic links for seamlessly deployment (current directory)
* TESTS!

## Contribution
If you like this project feel free to open a pull request/issue with your idea :)
