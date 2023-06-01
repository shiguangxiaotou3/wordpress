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