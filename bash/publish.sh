#!/bin/bash

# +----------------------------------------------------------------------
# ｜将本地文件发布到服务器
# +----------------------------------------------------------------------
# 包含服务器连接参数
. config.sh

spawn scp -r wp-content/plugins/crud/ $user@$host:/var/www/html/wordpress//wp-content/plugins
expect {
  "*password*" {
    send "$password\r";
    expect {
      "*please try again*" {
        puts "密码错误";
        exit
      }
      interact
    }
  }
}
