# Projeto PHP - foco em infraestrutura (DevOps)

Este projeto tem como finalidade criar uma suite de aplicações
que sigam os principios dos 12 fatores para aplicações 
(The Twelve-Factor App), de forma que o repositório seja autosuficiente,
aqui deve conter todas as branchs mínimas necessárias(test, master e dev),
para um trabalho em conjunto.

Como linguagem padrão utilizaremos o PHP como core (podendo ou não existir 
integrações com aplicações escritas em outras linguagens), o intuito é subir 
uma aplicação autosufiente, modular e escalável, com aspéctos declarativos 
de forma que a manutenção seja facilitada. Estes e outros exemplos de como 
funcionam aplicações com este perfil, encontram-se no site: 
https://12factor.net/pt_br/



##################################################

## Breve explicação sobre como lançar a aplicação:


Primeiro desinstalamos versões anteriores:
~~~
sudo apt-get remove docker docker-engine docker.io containerd runc
~~~
Em seguida, instalamos algumas das dependências para termos a versão correta do repositório
~~~
sudo apt-get install \
    ca-certificates \
    curl \
    gnupg \
    lsb-release
~~~
Adicionamos a GPG keyringS:
~~~
sudo mkdir -p /etc/apt/keyrings &&
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
~~~

Adicionando repositório na lista de fontes de instalação :
~~~
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
~~~
E por fim atualizamos os repositórios e instalamos uma versão específica, neste caso a <5:20.10.17~3-0~ubuntu-focal>, 1.6.6-1, e 2.6.0~ubuntu-focal,
colocarei como variável de ambiente desta forma:
~~~
export DOCKER_VERSAO=5:20.10.17~3-0~ubuntu-focal
export CONTAINERD_VERSAO=1.6.6-1
export DOCKER_COMPOSE_PLUGIN_VERSAO=2.6.0~ubuntu-focal
# por fim a instalação
sudo apt-get install docker-ce=$DOCKER_VERSAO docker-ce-cli=$DOCKER_VERSAO containerd.io=$CONTAINERD_VERSAO docker-compose-plugin=$DOCKER_COMPOSE_PLUGIN_VERSAO
~~~

##################################################

## Explicando os conceitos por trás de cada aplicação:

I. Base de Código
Uma base de código com rastreamento utilizando controle de revisão, muitos deploys
II. Dependências
Declare e isole as dependências
III. Configurações
Armazene as configurações no ambiente
IV. Serviços de Apoio
Trate os serviços de apoio, como recursos ligados
V. Construa, lance, execute
Separe estritamente os builds e execute em estágios
VI. Processos
Execute a aplicação como um ou mais processos que não armazenam estado
VII. Vínculo de porta
Exporte serviços por ligação de porta
VIII. Concorrência
Dimensione por um modelo de processo
IX. Descartabilidade
Maximizar a robustez com inicialização e desligamento rápido
X. Dev/prod semelhantes
Mantenha o desenvolvimento, teste, produção o mais semelhante possível
XI. Logs
Trate logs como fluxo de eventos
XII. Processos de Admin
Executar tarefas de administração/gerenciamento como processos pontuais

#####################################################

### referência adicional

https://stack.desenvolvedor.expert/appendix/docker/

#####################################################

## Step 1 - A base de tudo e a história da sua aplicação

Para ter um controle da aplicação, a melhor forma (e a determinante nos dias de hoje)
é com repositórios git, diversas são as arquiteturas para se controlar uma aplicação,
vai de acordo com a complexidade dos seus serviços, entre elas técnicas como monorepos
e repositórios variados. Para o Projeto PHP, escolhi a utilização de um repositório 
único, porque irei lidar apenas com alguns serviços, não muito grandes ao ponto da 
necessidade de serem repartidos entre equipes.

Começamos criando um repositório no github, e adicionamos o arquivo README.md,
preferi criar um arquivo localmente e mandar por upstream em um repositório ja existente
no github.
~~~
git init # inicializa o repositório

git add . # adiciona todos os arquivos, neste caso, apenas este README

git commit -m "Adicionando readme, first commit" #Empacotamos as alterações e atribuimos um hash a ela

git remote add origin  https://github.com/iagoambrosio/projectphp  master # adicionamos este repositório remoto na branch master

git push -u origin master # envia as alterações para o repositório remoto na branch princial (master)

git restore --source=master . # restaura o diretório de trabalho para o estado anterior ao commit
ou
git reset --hard master # redefine o HEAD atual para o estado da branch master, tanto HEAD quanto WORKDIR são 
resetados

git reset --soft master # redefine o HEAD atual para o estado da branch master, apenas o HEAD é redefinido, não apaga arquivos

git branch dev && git branch test # criamos as branches dev e test
~~~
A atenção se remonta a partir de agora para a branch dev, onde desenvolveremos a aplicação, para no final fazermos um merge na branch master, a branch dev 
deve se concentra em softwares para auxiliar o desenvolvimento em computadores locais, 
o ambiente deve ser enxuto com todas as variáveis simplificadas, 
coisas como banco de dados otimizado, variáveis simplificadas, bibliotecas de debug e etc.

A branch test deve conter os testes automatizados de distribuição, para que possamos verificar se a aplicação está funcionando corretamente, 
e assim gerando um merge na branch master. Todo fluxo da branch dev, assim que commitado e recebido push, 
deve ser megiado na test para após os testes subir para a master( mas isso fica para uma outra oportunidade, por enquanto tratamos isso como um conceito).

## Step 2 - Dependências, declarando tudo em um arquivo de configuração

Para melhor adequarmos a aplicação, colocarei aqui as versões utilizadas na alicação
para fins de referência:

 - Servidor web: nginx:1.22.0
 - Banco de dados: mysql:8.0.29
 - Redis:
 - Php-fpm: 8.1
 - php-mysqli: 8.1.2
 - Wordpress: 6.0.1
 - Certificados digitais ssl certbot: nightly
 - Docker: 5:20.10.17~3-0~ubuntu-focal
 - Containerd: 1.6.6-1
 - Plugin docker-compose: 2.6.0~ubuntu-focal

### O problema com ssl

O bom seria automatizar a instalação para utilização de ssl com dominios personalizados,
existem diversas soluções com nginx e certbot instalados juntos, onde passamos apenas o parametro do nome do dominio como variável
e o certificado é gerado automaticamente, porém, resolvi seguir com o certificado ssl gerado por um container do certbot, incluindo um trecho
na docker-compose.yml 
~~~
  certbot:
    image: certbot/certbot:nightly
    volumes:
      - ./docker/nginx/www/:/home/wordpress/:rw
      - ./docker/nginx/config/ssl/:/etc/letsencrypt/:rw
    networks:
      - projeto_php '
~~~
E rodando este comando em seguida para acessar o container:
~~~
sudo docker compose run -it --rm --entrypoint ""  certbot sh 
~~~
E por fim, gerando o certificado nas pastas certas
~~~
certbot certonly --webroot --agree-tos --no-eff-email --email iago_ambrosio@outlook.com  -w /home/wordpress -d devopers.ddns.net
~~~
Para mudar a pasta ssl identificada pelo nginx, também alterei a configuração padrão

~~~
# server {
#    listen 443 ssl http2;
#    listen [::]:443 ssl http2;
#    ssl_certificate /etc/nginx/ssl/nginx-selfsigned.crt;
#    ssl_certificate_key /etc/nginx/ssl/private/nginx-selfsigned.key;
#    
#location / {
#        root   /usr/share/nginx/html;
#        index  index.html index.htm;
#    }
#} 
~~~
Como não é escopo desta apresentação automatizar esta criação, irei manter sem a geração automatica de ssl por enquanto,
esta questão está atrelada a issue #1 , e será resolvida mais para frente.

## Step 3 - Configuração

A configuração precisa ser feita por meio de variáveis de ambiente, ou de alguma forma automatizada,
Como estou mexendo com a branch dev, estou utilizando configurações em texto plano, mas isso nunca deve ser comittado nos repositórios,
por encorrer em uma falha de segurança bem grave, recomendo que estes arquivos estejam fora do reposítório, 
se por acaso forem segredos, pode-se utilizar o próprio docker para guarda-los,
se você utiliza terraforms para gerar sua infraestrutura, é bom utilizar as variáveis de próprio terraforms para manter escondido estes arquivos,
é mais seguro do que fazer o up dos arquivos no servidor e remove-los depois

dois são os arquivos de variáveis de ambiente neste projeto:

 - dev_mysql.env 
 - dev_php.env (que será utilizado mais tarde)

e ainda um terceiro do próprio wordpress que é utilizado para acessar o banco de dados.

## Step 4 - serviços externos, e aplicação sem estado

