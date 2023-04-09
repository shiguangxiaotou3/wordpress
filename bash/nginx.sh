#!/usr/bin/expect

# Ubuntu 18.04使用expect登录
set user [ lindex $argv 0 ]
set host [ lindex $argv 1 ]
set password  [ lindex $argv 2 ]
set config  [ lindex $argv 3 ]
set timeout 3000

puts "$config"

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
      send "hostname\r";
      expect {
      "*${user}@*" {
        send "sudo apt-get update -y\r";
        expect {
          "*${user}@*" {
            send "sudo apt-get install nginx -y\r"
            expect {
              "*${user}@*" {
                send "sudo /etc/init.d/nginx restart\r";
                expect {
                  "*ok*" {
                    send "sudo cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.save\r";
                      expect {
                        "*${user}@*" {
                          send "cat>/etc/nginx/nginx.conf<<EOF\r${config}\rEOF\r";
                          send "sudo /etc/init.d/nginx restart\r";
                          interact
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
