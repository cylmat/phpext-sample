SHELL := /bin/bash

phpunit-bin:
	wget https://phar.phpunit.de/phpunit-7.2.phar
	mv phpunit-7.2.phar phpunit
	chmod +x phpunit

tests:
	./phpunit -c ./phpunit.xml
.PHONY: tests