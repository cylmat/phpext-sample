SHELL := /bin/bash

tests:
	./phpunit -c ./phpunit.xml
.PHONY: tests serve stop

#######
# BIN #
#######
phpunit-bin:
	wget https://phar.phpunit.de/phpunit-7.2.phar
	mv phpunit-7.2.phar phpunit
	chmod +x phpunit

##########
# SERVER #
##########
serve:
	php -t public -S localhost:83 &

stop:
	kill $$(ps | grep php | awk '{print $$1}')