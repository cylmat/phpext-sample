SHELL := /bin/bash

tests:
	./phpunit -c ./phpunit.xml
.PHONY: tests

#######
# BIN #
#######
phpunit-bin:
	wget https://phar.phpunit.de/phpunit-7.2.phar
	mv phpunit-7.2.phar phpunit
	chmod +x phpunit