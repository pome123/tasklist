FROM mysql:8.0.16
LABEL maintainer "YOUR NAME"

COPY mysql.cnf /etc/mysql/conf.d/mysql.cnf
RUN set -eux && \
  mkdir /var/lib/mysql-files