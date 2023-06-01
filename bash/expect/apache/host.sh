#!/bin/bash

domain=''
path=""
host=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot ${path}
    ServerAlias ${domain}
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF
)

sudo touch "/etc/apache2/sites-available/${domain}.conf"
echo "${host}" >> "/etc/apache2/sites-available/${domain}.conf"
sudo ln -s "/etc/apache2/sites-available/${domain}.conf" "/etc/apache2/sites-enabled/${domain}.conf"
sudo /etc/init.d/apache2 restart