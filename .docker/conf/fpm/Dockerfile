FROM phpdockerio/php73-fpm:latest
#Ubuntu 18.04 (Bionic Beaver)
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
#RUN apt-get update \
#    && apt-get -y --no-install-recommends install php7.3-mysql 

# Install phalcon
RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash \
    && apt-get update && apt-get install -y php5.6-dev php7.3-phalcon php7.0-intl

# Extensions
RUN apt-get update && apt-get install -y zip sqlite3

# Php ext
RUN apt-get install -y php-pear php-psr php7.3-sqlite3 php-curl php-ds php-mbstring php-xml php-zip php-redis

RUN update-alternatives --set php /usr/bin/php7.3 
#cli a2enmod proxy_fcgi setenvif &&  a2enconf php7.3-fpm

# clean
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#pecl channel-update pecl.php.net
#RUN pecl install ds

#clean 
#&& apt-get clean \
#    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#conf
#COPY overrides.conf /etc/php/7.3/fpm/pool.d/z-overrides.conf