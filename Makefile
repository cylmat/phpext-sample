SHELL := /bin/bash

phpunit-bin:
	wget https://phar.phpunit.de/phpunit-7.2.phar
	mv phpunit-7.2.phar phpunit
	chmod +x phpunit

tests:
	./phpunit --bootstrap src/bootstrap.php tests
.PHONY: tests