FROM phpdockerio/php74-fpm:latest
#Ubuntu (debian) 20.04 LTS (Focal Fossa)

# from docker-compose
ARG buildno
ARG servername
RUN echo "Build number: $buildno from $servername"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

##############
# Common: 
RUN apt-get install -y build-essential busybox software-properties-common

# Install
# be careful of cache
RUN apt-get update 
RUN apt-get install -y libzip4 libzip-dev lbzip2 libicu-dev libxml2-dev zlib1g-dev
RUN apt-get install -y apt-utils curl gnupg gnupg2 bzip2 sqlite3 vim wget g++ zip

# 7.4
RUN apt-get install -y php-dev php-mysql php-intl php-memcached php-soap 
RUN apt-get install -y php-curl php-ds php-mbstring php-pear php-psr php-xml php-zip

# Pecl ext
RUN pecl channel-update pecl.php.net && pecl update-channels

# clean
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/var/www"