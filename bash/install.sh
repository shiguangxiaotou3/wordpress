#!/bin/bash

# +----------------------------------------------------------------------
# ｜ubuntu 18.04 LAMP 环境搭建
# +----------------------------------------------------------------------

while getopts "d:p:n:w:" opt; do
  case $opt in
    d)
      domain=$OPTARG
      ;;
    p)
      path=$OPTARG
      ;;
    n)
      dbname=$OPTARG
      ;;
    w)
      password=$OPTARG
      ;;
    \?)
      echo "无效的选项：-$OPTARG"
      exit 1
      ;;
  esac
done

# 检查参数是否缺失
if [ -z "$domain" ] || [ -z "$path" ] || [ -z "$dbname" ] || [ -z "$password" ]; then
  echo "缺少参数，请输入以下参数值: "
  # 检查并要求输入缺失的参数
  if [ -z "$domain" ]; then
    read -p "-d 域名: " domain
  fi

  if [ -z "$path" ]; then
    read -p "-p 路径: " path
  fi

  if [ -z "$dbname" ]; then
    read -p "-n 数据库名: " dbname
  fi

  if [ -z "$password" ]; then
    read -p "-w 密码: " password
  fi
fi

echo "+----------------------------------------------------------------------"
echo "| ubuntu 18.04 LAMP 环境搭建"
echo "+----------------------------------------------------------------------"
echo "| 域名: $domain"
echo "| 路径: $path"
echo "| 数据库名: $dbname"
echo "| 密码: $password"
echo "+----------------------------------------------------------------------"
## ｜ubuntu 18.04 LAMP 环境搭建
## +----------------------------------------------------------------------
## 输出参数值
#echo "域名：$domain"
#echo "路径：$path"
#echo "数据库名：$dbname"
#echo "密码：$password"
#domain="test.shiguangxiaotou.com"
#path="/var/www/html/wordpress"
#password="wordpress"
#dbname="message"

#wget https://www.shiguangxiaotou.com/wp-content/uploads/install.sh && sudo bash install.sh
sudo apt-get update -y
sudo apt-get install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update -y
sudo apt-get install php7.4 -y
sudo apt-get install apache2 -y
sudo apt-get install mysql-server-5.7 -y
sudo apt-get install libapache2-mod-php7.4 -y
sudo apt-get install php7.4-fpm php7.4-mysql php7.4-gd php7.4-mbstring php7.4-bcmath -y
sudo apt-get install php7.4-xml php7.4-curl php7.4-redis php7.4-opcache php7.4-odbc  -y
sudo apt-get install php7.4-mysql php7.4-zip -y
sudo apt-get install zip  -y
sudo a2enmod rewrite
sudo apt-get install wget -y
sudo apt-get install expect -y
clear
echo "拓展安装完毕"

if [ -d "$path" ]; then
    # 检查目录是否为空
    if [ -z "$(ls -A $path)" ]; then
        echo ""
    else
        echo "目录存在但不为空"
        exit 1
    fi
else
    sudo mkdir "$path"
fi


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
clear
echo "站点配置完毕"


expect_str=$(cat <<EOF
#!/usr/bin/expect

spawn sudo mysql_secure_installation
set password [ lindex $argv 0 ]
expect {
  "*setup VALIDATE PASSWORD plugin*" {
    send "No\r";
    expect {
      "*New password:" {
        send "$password \r";
        expect {
          "Re-enter new password:" {
            send "$password \r";
            expect {
              "*Remove anonymous users?*" {
                send "Y\r";
                expect {
                  "Disallow root login remotely?" {
                    send "No\r"
                    expect {
                      "Remove test database and access to it?" {
                        send "Y\r";
                        expect {
                          "Reload privilege tables now?" {
                            send "Y\r";
                            expect {
                              "All done!" {
                                interact;
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
}
EOF
)

cd /root
sudo touch "mysql.sh"
echo "${expect_str}" >> "mysql.sh"
sudo chmod +x mysql.sh
sudo expect mysql.sh "$password"

sudo /etc/init.d/mysql restart
create_str=$(cat <<EOF
#!/usr/bin/expect

set dbname [ lindex $argv 0 ]
spawn sudo mysql -uroot -p
expect {
  "*password*" {
    send "${password}\r"
    expect {
      "*mysql>*" {
        send "CREATE database $dbname;\r"
        expect {
          "Query OK" {
            send "CREATE USER "$dbname"@"localhost" IDENTIFIED BY "$password";\r";
            expect {
              "Query OK" {
                send "GRANT ALL PRIVILEGES ON *.* TO "$dbname"@"localhost";\r";
                expect {
                  "Query OK" {
                    send "FLUSH PRIVILEGES;\r";
                    expect {
                      "Query OK" {
                        send "exit;\r";
                        interact;
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
}
EOF
)


sudo touch "create.sh"
echo "${create_str}" >> "create.sh"
sudo chmod +x create.sh
sudo expect create.sh "$dbname"
sudo /etc/init.d/mysql restart
clear
echo "数据库创建完毕"




cd "$path"
sudo wget https://www.shiguangxiaotou.com/wp-content/uploads/imessage.zip
sudo unzip imessage.zip
sudo cp -r "./wordpress/*" "$path"
sudo rm -R ./wordpress
sudo chmod -R 777 "$path"

