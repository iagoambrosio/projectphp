FROM php:8.1.9RC1-fpm-buster

RUN docker-php-ext-install mysqli

#copia arquivos de configuração
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./docker/php/pool.d/www.conf /usr/local/etc/pool.d/www.conf

# Cria grupos wordpress e usuario wordpress
RUN groupadd wordpress && useradd -ms /bin/bash -g wordpress wordpress
#create wordpress directory in home
RUN mkdir -p /home/wordpress/.ssh
#copia a chave privada para acessar o container sftp
COPY ./docker/sftp/id_rsa /home/wordpress/.ssh/authorized_keys
#change ownership of the key file.
RUN chown wordpress:wordpress /home/wordpress/.ssh/authorized_keys && chmod 600 /home/wordpress/.ssh/authorized_keys 
CMD php-fpm -F