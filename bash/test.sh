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