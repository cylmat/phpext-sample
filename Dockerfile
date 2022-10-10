# ###
# https://phpdocker.io
# ###

FROM phpdockerio/php74-fpm:latest
# Ubuntu (debian) 20.04 LTS (Focal Fossa)

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install
RUN apt-get update 
RUN apt-get install -y libzip4 libzip-dev lbzip2 libicu-dev libxml2-dev zlib1g-dev
RUN apt-get install -y apt-utils bzip2 curl git php-pear vim wget zip

# Php 7.4 ext
# http://ppa.launchpad.net/ondrej/php/ubuntu
RUN apt install -y \
    php7.4-dev \ 
    php7.4-curl \
    php7.4-ds \
    php7.4-intl \
    php7.4-mbstring \
    php7.4-memcached \
    php7.4-mysql \
    php7.4-psr \
    php7.4-soap \ 
    php7.4-xml \
    php7.4-zip

# Pecl
# RUN pecl channel-update pecl.php.net && pecl update-channels

# Clean
# RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Composer
# ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
# RUN mv ./composer.phar /usr/local/bin/composer 

WORKDIR /var/www

# CMD ["/usr/sbin/php-fpm7.4", "-O"]
