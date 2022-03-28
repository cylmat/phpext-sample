SHELL := /bin/bash
.PHONY: tests serve stop

#######
# BIN #
#######
phpunit-bin:
	wget https://phar.phpunit.de/phpunit-7.2.phar -O ./phpunit
	chmod +x ./phpunit

ps:
	apt update && apt install -y procps

netstat:
	apt install -y net-tools

##########
# SERVER #
##########
serve:
	php -t public -S localhost:83 &

#kill $$(ps | grep php | awk '{print $$1}')
stop:
	kill $$(netstat -pl | grep -oE [0-9]+\/php[^-] | cut -d'/' -f 1)

#########
# TESTS #
#########

test:
	./phpunit -c ./phpunit.xml

display:
	./phpunit -c ./phpunit.xml