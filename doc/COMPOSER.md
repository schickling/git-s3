# Composer
[Composer](http://getcomposer.org) is a tool for dependency management in PHP. It allows you to declare the dependent libraries your project needs and it will install them in your project for you.

## Installation

### Download composer
```sh
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
```

### Add to `$PATH`
Add the following add the end to your bash/zsh file (e.g. `.bashrc`, `.bash_profile`, ...)
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
