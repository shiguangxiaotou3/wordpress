#!/usr/bin/expect

# 交互登录服务器
set user [ lindex $argv 0 ]
set host [ lindex $argv 1 ]
set password  [ lindex $argv 2 ]
set mysqlUser [ lindex $argv 3 ]
set mysqlPassword [ lindex $argv 4 ]
set mysqlDb [ lindex $argv 5 ]
set sql [ lindex $argv 6 ]

set timeout 3000
spawn ssh $user@$host
expect  {
  "*yes/no*" {
    send "yes\r" ; exp_continue
    }
  "*password*" {
    send "$password\r";
    expect {
      "*please try again*" {
        puts "密码错误";
        exit
      }
      "*${user}@*" {
        send "mysql -u$mysqlUser -p\r"
        expect {
           "*password*" {
              send "$mysqlPassword\r"
              expect {
                "*mysql>*" {
                  send "USE $mysqlDb;\rSHOW TABLES;\r"
                   send "$sql\r"
                   interact
                }
              }
          }
        }
      }
    }
  }
}
