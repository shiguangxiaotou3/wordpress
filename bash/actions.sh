#!/bin/bash

# +----------------------------------------------------------------------
# ｜交互登录ubuntu18.04并执行一条命令
# +----------------------------------------------------------------------
function runCommand(){
  action=$1
if [ "$action" = ""  ]; then
    action="cd $serverPath"
fi
expect "$projectPath/bash/client.sh" "$user" "$host" "$password" "$action"
}

# +----------------------------------------------------------------------
# ｜将本地文件发布到服务器
# +----------------------------------------------------------------------
function publish() {
    scp -r $projectPath/wp-content/plugins/crud $user@$host:$serverPath/wp-content/plugins
#    scp -r $user@$host:$serverPath/wp-content/plugins/crud $projectPath/wp-content/plugins
}

function download() {
#    scp -r $projectPath/wp-content/plugins/crud/ $user@$host:$serverPath/wp-content/plugins
    scp -r $user@$host:$serverPath/wp-content/plugins/crud $projectPath/wp-content/plugins
}


# +----------------------------------------------------------------------
# ｜添加apache多站点配置
# +----------------------------------------------------------------------
function apacheAddHost(){
domain=$1
domainPath=$2
if [ "$domain" != "" ]; then
  if [ "$domainPath" != "" ]; then

read -d '' config<<EOF
  <VirtualHost *:80>
    DocumentRoot ${domainPath}
    ServerAlias ${domain}
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
  </VirtualHost>
EOF
read -d '' htaccess<<EOF
# use mod_rewrite for pretty URL support
RewriteEngine on
# if a directory or a file exists, use the request directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# otherwise forward the request to index.php
RewriteRule . index.php
EOF
  read -d '' action<<EOF
sudo touch /etc/apache2/sites-available/${domain}.conf
read -d '' str<<EOF
${config}
\EOF
echo "\$str" >> /etc/apache2/sites-available/${domain}.conf
sudo ln -s /etc/apache2/sites-available/${domain}.conf /etc/apache2/sites-enabled/${domain}.conf

read -d '' htaccess<<EOF
${htaccess}
\EOF
sudo touch ${domainPath}/.htaccess
echo "\$htaccess" >> ${domainPath}/.htaccess
certbot
EOF
  expect "$projectPath/bash/client.sh" "$user" "$host" "$password" "$action"

  fi
fi
}

# +----------------------------------------------------------------------
# ｜删除apache多站点配置
# +----------------------------------------------------------------------
function apacheDeleteHost(){
domain=$1
if [ "$domain" != "" ]; then
   read -d '' action<<EOF
sudo rm /etc/apache2/sites-enabled/${domain}.conf
sudo rm /etc/apache2/sites-available/${domain}.conf
sudo rm /etc/apache2/sites-enabled/${domain}-le.ssl.conf
sudo rm /etc/apache2/sites-available/${domain}-le.ssl.conf
EOF

  expect "$projectPath/bash/client.sh" "$user" "$host" "$password" "$action"
fi
}

# +----------------------------------------------------------------------
# ｜nginx代理配置
# +----------------------------------------------------------------------
function nginxProxy(){
config=`cat $projectPath/bash/nginx.conf`

expect "$projectPath/bash/nginx.sh" "$user" "$host" "$password" "$config"
}

# +----------------------------------------------------------------------
# ｜登录
# +----------------------------------------------------------------------
function loginServerMysql() {
  sql=$1
   expect "$projectPath/bash/mysql.sh" "$user" "$host" "$password" "$mysqlUser" "$mysqlPassword" "$mysqlDb" "$sql"
}

function Permission(){
  read -d '' action<<EOF
cd $serverPath\r
sudo rm -R wp-content/plugins/crud/backend/runtime\r
sudo mkdir wp-content/plugins/crud/backend/runtime\r
sudo chmod -R 777 wp-content/plugins/crud/backend/runtime\r
sudo rm -R wp-content/uploads/assets\r
sudo mkdir wp-content/uploads/assets\r
sudo chmod -R 777 wp-content/uploads/assets\r
sudo rm -R wp-content/plugins/crud/console/runtime\r
sudo mkdir wp-content/plugins/crud/console/runtime\r
sudo chmod -R 777 wp-content/plugins/crud/console/runtime\r
sudo rm -R wp-content/plugins/crud/library/a.txt\r
sudo touch wp-content/plugins/crud/library/a.txt\r
sudo chmod -R 777 wp-content/plugins/crud/library/a.txt\r
sudo chmod -R 777 wp-content/plugins/crud/common/runtime\r
EOF

  expect "$projectPath/bash/client.sh" "$user" "$host" "$password" "$action"
}
