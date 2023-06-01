#!/bin/bash

// +----------------------------------------------------------------------
// ｜ubuntu 18.04 LAMP 环境搭建
// +----------------------------------------------------------------------

sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.4 -y
sudo apt-get install apache2 -y
sudo apt install mysql-server-5.7 -y
sudo apt-get install libapache2-mod-php7.4 -y
sudo apt-get install php7.4-fpm php7.4-mysql php7.4-gd php7.4-mbstring php7.4-bcmath -y
sudo apt-get install php7.4-xml php7.4-curl php7.4-redis php7.4-opcache php7.4-odbc  -y
sudo apt-get install zip php7.4-mysql php7.4-zip -y
sudo a2enmod rewrite

sudo mysql_secure_installation
CREATE USER \'wordpress\'@\'localhost\' IDENTIFIED BY \'30BEApJHzk\';
GRANT ALL PRIVILEGES ON *.* TO \'wordpress\'@\'localhost\';
FLUSH PRIVILEGES;