FROM phpdockerio/php74-fpm:latest
#Ubuntu (debian) 20.04 LTS (Focal Fossa)

# from docker-compose
ARG buildno
ARG servername
RUN echo "Build number: $buildno from $servername"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

##############
# Common: apt-get install -y build-essential busybox software-properties-common

# Install
# be careful of cache
RUN apt-get update 
RUN apt-get install -y libzip4 libzip-dev lbzip2 zlib1g-dev libicu-dev libxml2-dev
RUN apt-get install -y apt-utils curl gnupg gnupg2 bzip2 sqlite3 vim wget g++ zip

### git, use with prompt and autocompletion
RUN apt-get install -y git

# 7.4
RUN apt-get install -y php7.4-dev php7.4-mysql php7.4-redis php7.4-intl php7.4-memcached php7.4-soap php7.4-pgsql php7.4-sqlite 
RUN apt-get install -y php-curl php-ds php-mbstring php-pear php-psr php-xml php-zip

#PECL
RUN pecl channel-update pecl.php.net && pecl update-channels

# composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
RUN mv /usr/local/bin/composer.phar /usr/local/bin/composer && composer --version

# phalcon
#RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash
#RUN apt-get update && apt-get install -y php-pear php5.6-dev php7.3-phalcon

# Pecl ext
RUN pecl channel-update pecl.php.net

###################################
# DATABASES
# DBA BERKELEY
RUN apt-get install -y php7.4-dba

# ODBC inst
#/etc/odbc.ini not needed
#/etc/odbcinst.ini
WORKDIR /tmp
RUN apt-get install -y odbcinst1debian2 libodbc1
RUN wget https://dev.mysql.com/get/Downloads/Connector-ODBC/8.0/mysql-connector-odbc_8.0.21-1ubuntu20.04_amd64.deb
RUN md5sum mysql-connector-odbc_8.0.21-1ubuntu20.04_amd64.deb
RUN test "$(md5sum mysql-connector-odbc_8.0.21-1ubuntu20.04_amd64.deb)" = "62e280b8d8e5d3531c6de2b57c37b1a5  mysql-connector-odbc_8.0.21-1ubuntu20.04_amd64.deb"
RUN dpkg -i mysql-connector-odbc_8.0.21-1ubuntu20.04_amd64.deb 
RUN apt-get install -y php7.4-odbc

# Php-Redis: https://github.com/phpredis/phpredis/
#RUN echo 'yes' | pecl install redis-5.3.1

# coverage
RUN apt-get install -y php7.4-xdebug php7.4-phpdbg
RUN pecl install pcov

# ################ #
# XHPROF (tideways)
WORKDIR /tmp
RUN apt-get install -y graphviz
RUN wget https://github.com/tideways/php-xhprof-extension/archive/master.zip && unzip master.zip && rm master.zip
WORKDIR /tmp/php-xhprof-extension-master 
RUN phpize && ./configure && make && make install
#RUN echo "extension=tideways_xhprof.so" > /etc/php/7.4/fpm/conf.d/xhprof.ini

# clean
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/var/www"