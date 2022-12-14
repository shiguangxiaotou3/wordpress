<?php


class WebSocket{
    public $address ="0.0.0.0";
    public $port=81;
    public $cont =0;
    public $clients =[];
    private $_server;


    public function __construct(){
        echo "开始创建对象...".PHP_EOL;
        $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or self::error($socket );
        echo "绑定端口...".PHP_EOL;
        $tmp = socket_bind($socket,$this->address,$this->port) or self::error($tmp);;
        echo "开始监听...".PHP_EOL;
        $tmp = socket_listen($socket, 4) or self::error($tmp );
        echo "服务启动成功".PHP_EOL;
        $this->_server = &$socket;
    }

    public static function error($server){
        die(socket_strerror(socket_last_error($server)) . "/n");
    }

    public function sendMessage($client,$message){
        socket_write($client, $message, strlen($message));
    }

    public function analysis($data){
        $herder =[];
        $lines = preg_split("/\r\n/",$data);
        foreach ($lines as $line){
            $row =explode(": ",$line);
            if(count($row) ==2){
                $herder[$row[0]] =$row[1];
            }
        }
        return $herder;
    }

    public function getMessage(){
        $client = socket_accept($this->_server);
        $buf = $this->analysis( socket_read($client, 1024));
        $response = $this->hand_shake($buf,$client);
        socket_write($client,$this->encode('asdas'));
//        return  $this->analysis( socket_read($client, 1024));
    }
    public function hand_shake($buffer,$client){
        $headers = $this->analysis($buffer);
        $key =$headers['Sec-WebSocket-Key'];
        var_dump($headers);
        $new_key = base64_decode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
        $message = "HTTP/1.1 101 Switching Protocols\r\n";
        $message .= "Upgrade: websocket\r\n";
        $message .= "Sec-WebSocket-Version: 13\r\n";
        $message .= "Connection: Upgrade\r\n";
        $message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($client,$message,strlen($message));
        echo $message;
        return true;
    }

    /**
     * 加密
     * @param $message
     * @return string
     */
    public function encode($message){
        $len = strlen($message);
        if($len <=125){
            return "\x81".chr($len).$message;
        }elseif ($len<=65535){
            return "\x81".chr(126).pack("n",$len).$message;
        }else{
            return "\x81".chr(127).pack("xxxxN",$len).$message;
        }
    }

    /**
     * 解密
     * @param $buffer
     * @return string|null
     */
    public function decode($buffer){
        $len = $masks = $data = $decode =null;
        $len = ord($buffer[1]) & 127;
        if($len === 126){
            $masks = substr($buffer,4,4);
            $data = substr($buffer,8);
        }elseif ($len ===127){
            $masks = substr($buffer,10,4);
            $data = substr($buffer,14);
        }else{
            $masks = substr($buffer,2,4);
            $data = substr($buffer,6);
        }
        for ($index =0;$index <strlen($data);$index++){
            $decode .= $data[$index] ^ $masks[$index % 4];
        }
        return $decode;
    }

    public function search_socket($client ,$clients){
        $key = array_search($client,$clients);
        return $key === null ? false:$key;
    }

    public function run(){
        $clients = [$this->_server];
        do {
            $read =$clients;
            $write =null;
            $except =null;
            if (socket_select($read,$write,$except,null)>0){
                foreach ($read as $item){
                    if($item === $this->_server){
                        // 首次链接
                        if(!$socket_client = socket_accept($item)){
                            continue;
                        }else{
                            $client_data = @socket_read($socket_client,1024);
                            if($client_data=== false){
                                socket_close($socket_client);
                            }
                            // 建立握手
                            $this->hand_shake($client_data ,$socket_client);
                            // 获取客户端信息
                            socket_getpeername($socket_client,$ip,$port);
                            $clients[$ip.":".$port]=  $socket_client;
                            echo "有一个新的链接".$ip.":".$port."\n";
                            echo "message:".$client_data."\n";
                        }
                    }else{
                        $result = @socket_recv($item,$msg,1024,0);
                        if($result === false){
                            continue;
                        }
                        if ($result ===0 ){
                            socket_close($item);
                            $key1 =array_search($item,$read);
                            unset($read[$key1]);
                            $key2 = array_search($item,$clients);
                            unset($clients[$key2]);
                        }else{
                            // 解码客户端消息
                            $web_msg= $this->decode($msg);
                            $id = $this->search_socket($item ,$clients);
                            echo "client:".$id .":".$web_msg;
                            // 加密客户端消息
                            $response = $this->encode($web_msg);
                            // 广播
                            foreach ($clients as $client){
                                if($client != $this->_server ){
                                    if(false == @socket_write($client,$response,strlen($response))){
                                        socket_close($client);
                                        $key1 = array_search($client,$read);
                                        unset($read[$key1]);
                                        $key2 = array_search($client,$clients);
                                        unset($clients[$key2]);
                                        echo "";
                                    }
                                }
                            }
                        }

                    }
                }
//                if(in_array( $this->_server,$read)){
//                    $client = socket_accept($this->_server);
//                    $clients[] =$client;
//                    socket_getpeername($client,$ip,$port);
//                    $key = array_search($this->_server,$read);
//                    unset($read[$key]);
//                }
//                if (count($read)>0){
//                    foreach ($read as $client_item){
//                        // 读取用户发过来的数据
//                        if(false === $msg = @socket_read($client_item ,1024)){
//                            socket_close($client_item);
//                            $key = array_search($client_item,$read);
//                            unset($read[$key]);
//                            unset($clients[$key]);
//                            echo "客户端:".$key."链接失败\n";
//                            continue;
//                        }
//                        // 发送给自己
//                        if(false == @socket_write($client_item,$msg)){
//                            socket_close($client_item);
//                            $key1= array_search($client_item,$read);
//                            unset($read[$key1]);
//                            $key2= array_search($client_item,$clients);
//                            unset($clients[$key2]);
//                            echo "断开我自己的链接".$key2;
//                        }
//
//                    }
//                }
            }
        } while (true);
    }
}

$server = new WebSocket();
$server->run();
