FROM firmchecker/amazonlinux2-php8:latest

## libs for wkhtmltopdf
# RUN yum install -y libXrender fontconfig urw-fonts libXext

# php-xdebug
RUN yum install -y gcc make

RUN wget https://xdebug.org/files/xdebug-3.1.5.tgz --no-check-certificate -O xdebug-3.1.5.tgz \
  && tar -xvzf xdebug-3.1.5.tgz \
  && cd xdebug-3.1.5 \
  && phpize \
  && ./configure \
  && make \
  && cp modules/xdebug.so /usr/lib64/php/modules \
  && echo $'[XDebug] \n\
zend_extension=/usr/lib64/php/modules/xdebug.so \n\
xdebug.mode=debug,profile,trace \n\
xdebug.remote_handler="dbgp" \n\
xdebug.discover_client_host=0 \n\
xdebug.client_port = 9003 \n\
xdebug.client_host="host.docker.internal" \n\
xdebug.idekey="VSCODE" \n\
xdebug.start_with_request=yes \n\
xdebug.log=/var/log/xdebug.log' >> /etc/php.ini

# php math ext
RUN yum install -y php-bcmath php-gmp

COPY etc/ssl/certs/fc_core_mkcert.key.crt /etc/pki/tls/certs/localhost.crt
COPY etc/ssl/private/fc_core_mkcert.key /etc/pki/tls/private/localhost.key

RUN rm -rf /etc/httpd/conf.d/fc-site.conf && rm -rf /etc/httpd/conf.d/fc-site-ssl.conf

COPY etc/fcapi-site.conf /etc/httpd/conf.d/
COPY etc/fcapi-site-ssl.conf /etc/httpd/conf.d/

CMD ["/usr/local/bin/supervisord"]
