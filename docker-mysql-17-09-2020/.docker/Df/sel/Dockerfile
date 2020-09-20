# PhantomJs
FROM nkovacs/selenium-standalone-phantomjs

#ENV OPENSSL_CONF=/etc/ssl/
#export OPENSSL_CONF=/etc/ssl/

WORKDIR /tmp

RUN wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-1.9.7-linux-x86_64.tar.bz2
RUN bzip2 -dk phantomjs-1.9.7-linux-x86_64.tar.bz2
RUN tar -xf phantomjs-1.9.7-linux-x86_64.tar
RUN sudo mv /usr/local/bin/phantomjs /usr/local/bin/bak_phantomjs
RUN sudo cp phantomjs-1.9.7-linux-x86_64/bin/phantomjs /usr/local/bin

WORKDIR /
RUN phantomjs --version