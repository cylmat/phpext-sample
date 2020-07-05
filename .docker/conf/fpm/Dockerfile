FROM phpdockerio/php73-fpm:latest
# Ubuntu 18.04 (Bionic Beaver)
WORKDIR "/appli"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install
# be careful of cache
RUN apt-get update && ENV=_docker_id_to_update_446361d45899253
RUN apt-get install -y curl sqlite3 php7.3-dev vim wget zip

# Php ext
RUN apt-get install -y php-curl php-ds php-mbstring php-redis php-pear 
RUN apt-get install -y php-sqlite3 php7.3-soap php-psr php-xml php-zip

# php.ini
RUN sed -i 's/;extension=soap/extension=soap/' /etc/php/7.3/fpm/php.ini
RUN sed -i 's/pm.max_children = 5/pm.max_children = 25/' /etc/php/7.3/fpm/pool.d/www.conf

# Pecl ext
RUN pecl channel-update pecl.php.net
#RUN printf "yes\n" | pecl install swoole

# coverage
RUN apt-get install -y php-xdebug php7.3-phpdbg
RUN pecl install pcov
RUN echo "\nextension=pcov.so" >> /etc/php/7.3/fpm/php.ini
RUN echo "\nextension=pcov.so" >> /etc/php/7.3/cli/php.ini

# Phalcon #php7.3-phalcon
RUN apt-get install -y php-phalcon
#RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | \
#bash && apt-get update && apt-get install -y php-pear php5.6-dev php7.3-phalcon php-ds php7.0-intl sqlite3 phpldapadmin

# php.ini
#sed ;extension=xsl /etc/php/7.3/fpm/php.ini

#SWOOLE : take much time
#RUN echo "extension=swoole.so" >> /etc/php/7.3/fpm/php.ini

# clean
#RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*