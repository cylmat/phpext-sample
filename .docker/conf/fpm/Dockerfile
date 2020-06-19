FROM phpdockerio/php73-fpm:latest
# Ubuntu 18.04 (Bionic Beaver)
WORKDIR "/appli"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install
# be careful of cache
RUN apt-get update && ENV=_docker_cache_81636195849153
RUN apt-get install -y curl sqlite3 php7.3-dev wget zip

# Php ext
RUN apt-get install -y php-curl php-ds php-pear php-psr 
RUN apt-get install -y php7.3-sqlite3 php-mbstring php7.3-soap
RUN apt-get install -y php-xml php-zip

# php.ini
RUN sed -i 's/;extension=soap/extension=soap/' /etc/php/7.3/fpm/php.ini

# Pecl ext
RUN pecl channel-update pecl.php.net
#RUN printf "yes\n" | pecl install swoole

# php.ini
#sed ;extension=xsl /etc/php/7.3/fpm/php.ini
#RUN echo "extension=swoole.so" >> /etc/php/7.3/fpm/php.ini

# clean
#RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*