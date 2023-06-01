#!/usr/bin/expect


# 交互登录服务器
#!/usr/bin/expect

# 交互登录服务器
set user [ lindex $argv 0 ]
set host [ lindex $argv 1 ]
set password  [ lindex $argv 2 ]
set action [ lindex $argv 3]
set timeout 30

spawn ssh $user@$host

expect  {
  "yes/no" {
      send "yes\r" ; exp_continue;
  }
  "password:" {
    send "$password\r";
    expect {
      "Permission denied, please try again." {
        puts "密码错误";
        exit
      }
      "${user}@*" {
        send "hostname\r"
        send "$action\r"
        interact
      }
    }
  }
}
