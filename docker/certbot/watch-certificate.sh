#!/bin/sh
if [ -d /etc/letsencrypt/live ];
then
echo "Já existem certificados SSL na sua raiz, atualizado então para o modo watch"
else
certbot certonly --webroot --agree-tos --no-eff-email --email no-interactive@project.php.co -w /home/wordpress -d $DOMAIN
fi

x=1
while [ $x -eq 1 ] ; do 
   sleep 50d ;
   certbot renew  --cert-name $DOMAIN --force-renew 
done 

