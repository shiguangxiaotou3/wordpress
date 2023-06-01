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
            send "CREATE USER "$dbname"@"localhost" IDENTIFIED BY "$wordpress";\r";
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