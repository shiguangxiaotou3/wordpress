#!/bin/bash
# +----------------------------------------------------------------------
# ｜服务器管理命令
# +----------------------------------------------------------------------

# 包含服务器连接参数
. config.sh

# +----------------------------------------------------------------------
# ｜交互登录ubuntu18.04并执行一条命令
# +----------------------------------------------------------------------
function runCommand(){
  action="sudo /etc/init.d/apache2 restart"
if [ "$action" = ""  ]; then
    action="cd $serverPath"
fi
expect client.sh "$user" "$host" "$password" "$action"
}

# +----------------------------------------------------------------------
# ｜将本地文件发布到服务器
# +----------------------------------------------------------------------
function publish() {
   spawn scp -r $basePath/wp-content/plugins/crud/ $user@$host:$serverPath/wp-content/plugins
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
  read -d '' action<<EOF
sudo touch /etc/apache2/sites-available/${domain}.conf
read -d '' str<<EOF
${config}
\EOF
echo "\$str" >> /etc/apache2/sites-available/${domain}.conf
sudo ln -s /etc/apache2/sites-available/${domain}.conf /etc/apache2/sites-enabled/${domain}.conf
certbot
EOF
expect client.sh "$user" "$host" "$password" "$action"

  fi
fi
}

# +----------------------------------------------------------------------
# ｜删除apache多站点配置
# +----------------------------------------------------------------------
apacheDeleteHost(){
domain=$1
if [ "$domain" != "" ]; then
   read -d '' action<<EOF
sudo rm /etc/apache2/sites-enabled/${domain}.conf
sudo rm /etc/apache2/sites-available/${domain}.conf
sudo rm /etc/apache2/sites-enabled/${domain}-le.ssl.conf
sudo rm /etc/apache2/sites-available/${domain}-le.ssl.conf
EOF
echo "$action"
#  expect client.sh "$user" "$host" "$password" "$action"
fi
}

# +----------------------------------------------------------------------
# ｜nginx代理配置
# +----------------------------------------------------------------------
function nginxProxy(){
config=`cat $basePath/bash/nginx.conf`
expect nginx.sh "$user" "$host" "$password" "$config"
}


runCommand
##apacheAddHost "tesh.shiguangxiaotou.com" "/var/www/html/test"
#apacheDeleteHost "tesh.shiguangxiaotou.com"



