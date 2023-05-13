#!/bin/sh
if [ -d /etc/letsencrypt/live ];
then
echo "Já existem certificados SSL na sua raiz, atualizado então para o modo watch"
else
certbot certonly --webroot --agree-tos --no-eff-email --email no-interactive@project.php.co -w /home/wordpress -d $DOMAIN
fi

y=1
while [ $y -eq 1 ] ; do
x=$(date | cut -d ' ' -f 3)

#arquivo stat /etc/letsencrypt/archive/elementusdesign.duckdns.org/ | grep +0000 | grep Change: | tr -s ' ' | cut -d ' ' -f 2 | sed 's/-/ /g' | cut -d ' ' -f 3 | sed 's/-/ /g' | cut -d ' ' -f 3
while [ $x -eq 1 ] ; do 
   certbot renew  --cert-name $DOMAIN --force-renew
   echo "Certificado renovado, aguardando um dia para o loop"
   sleep 1d ;
done
done 

