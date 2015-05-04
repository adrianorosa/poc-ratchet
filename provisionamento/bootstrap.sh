#!/bin/bash

DIR_WWW='/var/www'
DIR_VENDOR='/var/www/vendor'

# Marcando inicio do provisionamento
echo -e "\e[33mIniciando o provisionamento ...\e[0m"
sudo apt-get update
# Instalando utilitários e editor
sudo apt-get install -y htop vim git python-software-properties
# Adicioando PPA para php 5.5
sudo apt-add-repository -y ppa:ondrej/php5
sudo apt-get update
# Instalando servidor Web
sudo aptitude install -y apache2 php5 php5-curl php5-mysql
# Configurando para não aparecer warning quando reinicia o apache
echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Habilitando o módulo rewrite do apache
sudo a2enmod rewrite 
sudo sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/sites-available/default
sudo service apache2 restart 
# Encerrando o provisionamento
echo -e "\e[33mProvisionamento finalizado com sucesso!!!\e[0m"
