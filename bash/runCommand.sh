#!/bin/bash

projectPath="/Users/wanlong/web/wp"
. "$projectPath/bash/config.sh"
. "$projectPath/bash/actions.sh"
functionName=$1

if [ "$functionName" = "" ]; then
 runCommand
fi

if [ "$functionName" = "runCommand" ]; then
 runCommand "$2"
fi

if [ "$functionName" = "publish" ]; then
 publish
fi

if [ "$functionName" = "download" ]; then
 download
fi

if [ "$functionName" = "apacheAddHost" ]; then
 apacheAddHost "$2" "$3"
fi

if [ "$functionName" = "apacheDeleteHost" ]; then
 apacheDeleteHost "$2"
fi

if [ "$functionName" = "nginxProxy" ]; then
 nginxProxy "$2"
fi

if [ "$functionName" = "loginServerMysql" ]; then
 loginServerMysql "$2"
fi

if [ "$functionName" = "Permission" ]; then
 Permission
fi

if [ "$functionName" = "mysqldump" ]; then
 mysqldump
fi