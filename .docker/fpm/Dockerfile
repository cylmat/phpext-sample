FROM phpdockerio/php73-fpm:latest
# Ubuntu 18.04 LTS (Bionic Beaver)

WORKDIR "/appli"

# Fix debconf warnings upon build
#ARG DEBIAN_FRONTEND=noninteractive

# Install
# be careful of cache
RUN apt-get update && ENV=_docker_id_to_update_eg1641h45899
RUN apt-get install -y curl sqlite3 php7.3-dev vim wget zip

# git
RUN apt-get install -y git

# Php ext
RUN apt-get install -y php-curl php-ds php-mbstring php-redis php7.3-intl php-pear php7.3-mysql
RUN apt-get install -y php7.3-sqlite3 php7.3-soap php-psr php-xml php-zip

# php.ini
#RUN sed -i 's/;extension=soap/extension=soap/' /etc/php/7.3/fpm/php.ini
#RUN sed -i 's/pm.max_children = 5/pm.max_children = 25/' /etc/php/7.3/fpm/pool.d/www.conf
COPY ./php.ini /etc/php/7.3/fpm/php.ini
COPY ./www.conf /etc/php/7.3/fpm/pool.d/www.conf

# Pecl ext
RUN pecl channel-update pecl.php.net

# coverage
#REQUIRE php7.3-dev php-pear
RUN apt-get install -y php-xdebug php7.3-phpdbg
RUN pecl install pcov
RUN echo "\nextension=pcov.so" >> /etc/php/7.3/cli/php.ini

# clean
#RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*