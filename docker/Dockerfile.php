FROM ubuntu:jammy

RUN apt update && apt insall \
    php-fpm:7.4-fpm -y

RUN groupadd wordpress && useradd -ms /bin/bash -g wordpress wordpress

RUN mkdir -p /home/wordpress/.ssh

COPY ./sftp/id_rsa /home/wordpress/.ssh/id_rsa

RUN chown wordpress:wordpress /home/wordpress/.ssh/authorized_keys && chmod 600 /home/wordpress/.ssh/authorized_keys 
