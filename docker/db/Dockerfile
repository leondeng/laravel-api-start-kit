FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD password

COPY devdb.cnf /etc/mysql/conf.d/

RUN mkdir -p /var/log/mysql && \
    chmod 777 /var/log/mysql && \
    touch /var/log/mysql/mysql.err && \
    touch /var/log/mysql/mysql.queries && \
    chmod 666 /var/log/mysql/mysql.err && \
    chmod 666 /var/log/mysql/mysql.queries

# RUN apt-get update && apt-get install -y less
