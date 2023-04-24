#!/bin/bash

# +----------------------------------------------------------------------
# ｜服务器登陆通知
# +----------------------------------------------------------------------
# ｜ 监听服务器用户登陆
# ｜ step 1:
# ｜   Linux
# ｜     Debian/Ubuntu：`sudo apt-get install jq`
# ｜     RHEL/CentOS/Fedora：`sudo yum install jq`
# ｜   macOS
# ｜   Homebrew：`brew install jq`
# ｜ step 2:
# ｜   `sudo touch /etc/profile.d/login.sh`
# ｜ step 3:
# ｜  `sudo nano /etc/profile.d/login.sh` 赋值这段代码
# ｜ step 4:
# ｜   `sudo chmod +x /etc/profile.d/login.sh`
# +----------------------------------------------------------------------

server=$(hostname)
ip=${SSH_CLIENT%% *}
user=$(getent passwd `who` | head -n 1 | cut -d : -f 1)
if [ "" = "$user" ]; then
  user="default"
fi

if [ "$ip" = "" ]; then
  ip="default"
fi

url="https://www.shiguangxiaotou.com/wp-json/crud/api/server/login"
response=$(curl -s -X POST --data-urlencode "server=$server" --data-urlencode "name=$user" --data-urlencode "ip=$ip" $url)
echo "$response" | jq '.'
