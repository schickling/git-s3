# Composer
[Composer](http://getcomposer.org) is a tool for dependency management in PHP. It allows you to declare the dependent libraries your project needs and it will install them in your project for you.

## Installation

### Download composer
```sh
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
```

### Add to `$PATH`
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
$ cd
$ vim .composer/composer.json
```

And add the following line a the bottom (don't forget the comma on the line before):

```json
	"minimum-stability": "dev"
```

After that your file looks perhaps like this:
```json
{
    "require": {
        "schickling/git-s3": "dev-master"
    },
	"minimum-stability": "dev"
}
```
