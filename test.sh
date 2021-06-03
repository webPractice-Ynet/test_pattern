#!/bin/sh

vendor/bin/phpstan analyse -c phpstan.neon -l 3 ./app
php ./vendor/phpunit/phpunit/phpunit $1