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
    && apt-get update && apt-get install -y php-pear php5.6-dev php7.3-phalcon php-ds php7.0-intl sqlite3 phpldapadmin

#pecl channel-update pecl.php.net
#RUN pecl install ds

#clean 
#&& apt-get clean \
#    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#conf
#COPY overrides.conf /etc/php/7.3/fpm/pool.d/z-overrides.conf

# Extensions
RUN apt-get update && apt-get install -y php-psr php-net-ldap3 libldap2-dev libldap-common ldap-auth-client 
RUN apt-get install -y php7.3-ldap php7.3-sqlite3 php-curl php-mbstring php-xml php-zip php-soap php7.3-soap php-redis

RUN update-alternatives --set php /usr/bin/php7.3 
#cli a2enmod proxy_fcgi setenvif &&  a2enconf php7.3-fpm

#RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*