#! /bin/sh

# halt on error
set -e

# install composer dependencies
echo "Installing dependencies..."

if command -v composer > /dev/null; then
	composer install --no-dev
else
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install --no-dev
fi

# run configuration
php git-s3 config

# finish
echo ""
echo "Good job."
echo "Installation/Update was successful. Now type \"./git-s3 deploy\" to deploy your repository to your s3 bucket."