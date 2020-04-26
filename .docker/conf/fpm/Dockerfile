FROM phpdockerio/php73-fpm:latest
# Ubuntu 18.04 (Bionic Beaver)
WORKDIR "/appli"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install
RUN apt-get update && apt-get install -y curl sqlite3 php7.3-dev wget zip

# Php ext
RUN apt-get install -y php-pear php-psr php7.3-sqlite3 php-curl php-ds php-mbstring php-xml php-zip

# Pecl ext
RUN pecl channel-update pecl.php.net
#RUN printf "yes\n" | pecl install swoole

# php.ini
#sed ;extension=xsl /etc/php/7.3/fpm/php.ini
#RUN echo "extension=swoole.so" >> /etc/php/7.3/fpm/php.ini

# clean
#RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*