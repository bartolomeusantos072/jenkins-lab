FROM mysql:8.0

ENV MYSQL_ROOT_PASSWORD=123456

ENV MYSQL_DATABASE=cadastro

COPY init.sql /docker-entrypoint-initdb.d/01-init.sql
