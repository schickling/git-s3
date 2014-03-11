# Composer
[Composer](http://getcomposer.org) is a tool for dependency management in PHP. It allows you to declare the dependent libraries your project needs and it will install them in your project for you.

## Installation

### Download composer
```sh
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
```

### Add to `$PATH`
Add the following at the end to your bash/zsh file (e.g. `.bashrc`, `.bash_profile`, ...)
```sh
PATH=$HOME/.composer/vendor/bin:$PATH
```

## Install git-s3 as global application
```sh
$ composer global require schickling/git-s3:dev-master
```

## Troubleshooting

### minimum-stability

![](http://i.imgur.com/YmEzFfQ.png)

#### Solution
```sh
$ vim ~/.composer/composer.json
```

And add the following line at the bottom (don't forget the comma on the line before). If the file is empty just copy the `composer.json` from below:

```json
	"minimum-stability": "dev"
```

After that your `composer.json` looks perhaps like this:
```json
{
    "require": {
        "schickling/git-s3": "dev-master"
    },
	"minimum-stability": "dev"
}
```

## Installation on Windows


### Install php (if it's not installed already)

I recommend using [Chocolatey] (http://chocolatey.org/packages?q=php):
```sh
$ cinst php
```

Close your cmd window, then open a command window. type:
```sh
$ php
```

to make sure you can access the php command

### Download composer
```sh
$ curl -sS https://getcomposer.org/installer | php
```

## Install git-s3
```sh
$ php composer.phar global require schickling/git-s3:dev-master
```

## Add git-s3 to PATH
modify your environment PATH when git-s3 was installed -- for example, mine was installed under <user_directory>\AppData\Roaming\Composer\vendor\bin

## git-s3 is now ready for use
go ahead and configure [git-s3] (https://github.com/schickling/git-s3)
