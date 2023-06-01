#!/bin/bash


bash_command_ste=$(cat <<EOF
#!/bin/bash
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
EOF
)

sudo touch /etc/profile.d/login.sh
echo "$bash_command_ste" >> "/etc/profile.d/login.sh"
sudo chmod +x /etc/profile.d/login.sh