FROM phpdockerio/php73-fpm:latest
#Ubuntu 18.04 (Bionic Beaver)
WORKDIR "/appli"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Extensions
RUN apt-get update && apt-get install -y zip sqlite3

# Php ext
RUN apt-get install -y php-pear php-psr php7.3-sqlite3 php-curl php-ds php-mbstring php-xml php-zip

# clean
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*