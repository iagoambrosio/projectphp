FROM ubuntu:jammy

#enviroment variables for Debian Frontend
ENV DEBIAN_FRONTEND=noninteractive 
#enviorment variable for tzdata
ENV TZ=Etc/UTC
#install php-fpm8.1
RUN apt update && apt install php-fpm=2:8.1+92ubuntu1 -y

#copia arquivos de configuração
COPY ./docker/php/php.ini /etc/php/8.1/fpm/php.ini
COPY ./docker/php/php-fpm.conf /etc/php/8.1/fpm/php-fpm.conf
COPY ./docker/php/pool.d/www.conf /etc/php/8.1/fpm/pool.d/www.conf

# Cria grupos wordpress e usuario wordpress
RUN groupadd wordpress && useradd -ms /bin/bash -g wordpress wordpress
#create wordpress directory in home
RUN mkdir -p /home/wordpress/.ssh
#copia a chave privada para acessar o container sftp
COPY ./docker/sftp/id_rsa /home/wordpress/.ssh/authorized_keys
#change ownership of the key file.
RUN chown wordpress:wordpress /home/wordpress/.ssh/authorized_keys && chmod 600 /home/wordpress/.ssh/authorized_keys 

CMD php-fpm8.1 -F