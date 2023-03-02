<?php


namespace console\controllers;


use yii\console\Controller;

/**
 * Socket 服务
 * @package console\controllers
 */
class SocketController extends Controller
{

    public $address ="0.0.0.0";
    public $port=8081;
    private $_server;

    public function start(){
        echo "开始创建对象...".PHP_EOL;
        $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or self::error($socket );
        echo "绑定端口:".$this->address.":".$this->port."...".PHP_EOL;
        $tmp = socket_bind($socket,$this->address,$this->port) or self::error($tmp);;
        echo "开始监听...".PHP_EOL;
        $tmp = socket_listen($socket, 4) or self::error($tmp );
        echo "服务启动成功".PHP_EOL;
        $this->_server = &$socket;
    }


    public static function error($server){
        die(socket_strerror(socket_last_error($server)) . "/n");
    }
    /**
     * 解析http报文为数组
     * @param $data
     * @return array
     */
    public function analysisBuffer($data){
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

    /**
     * 返回报文
     * @param $buffer
     * @param $client
     * @return bool
     */
    public function hand_shake($buffer,$client){
        $headers = $this->analysisBuffer($buffer);
        $key =$headers['Sec-WebSocket-Key'];
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
        $message = "HTTP/1.1 101 Switching Protocols\r\n";
        $message .= "Upgrade: websocket\r\n";
        $message .= "Sec-WebSocket-Version: 13\r\n";
        $message .= "Connection: Upgrade\r\n";
        $message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($client,$message,strlen($message));
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

    /**
     * @param $item
     * @param $clients
     * @return string
     */
    public function first($item,&$clients){
        // 首次链接
        if (!$socket_client = socket_accept($item)) {
            return false;
        } else {
            $client_data = @socket_read($socket_client, 1024);
            if ($client_data === false) {
                socket_close($socket_client);
            }
            // 建立握手
            $this->hand_shake($client_data, $socket_client);
            // 获取客户端信息
            socket_getpeername($socket_client, $ip, $port);
            $clients[$ip . ":" . $port] = $socket_client;
            echo "有一个新的链接" . $ip . ":" . $port . "\n";
        }
    }

    /**
     * @param $clients
     * @param $read
     * @param $client
     */
    public function deleteClient(&$clients,&$read,$client){
        if($client !== 0){
            socket_close($client);
            $key1 =array_search($client,$read);
            unset($read[$key1]);
            $key2 = array_search($client,$clients);
            unset($clients[$key2]);
            echo '断开链接：'.$key2."\n";
        }
    }

    /**
     * 向起他客户端发送数据
     * @param $clients
     * @param $read
     * @param $message
     */
    public function broadcast(&$clients,&$read,$message){
        foreach ($clients as $client){
            if($client != $this->_server ){
                if(false == @socket_write($client,$message,strlen($message))){
                    $this->deleteClient($clients,$read,$client);
                }
            }
        }
    }

    /**
     * 向返回的数据中添加历史数据,并加密
     * @param $msg
     * @param $clients
     * @param $item
     * @param $history
     */
    public function addHistory($msg,&$history,&$clients,&$item){
        // 解码客户端消息
        $json_str = $this->decode($msg);
        $id = array_search($item ,$clients);
        echo "client:".$id ."说:".$json_str."\n";

        $response= $tmp =json_decode($json_str,true);
        $response['history'] =$history;
        $history[] =$tmp;
        // 加密客户端消息
        return $this->encode(json_encode( $response));
    }

    /**
     * 运行Socket
     */
    public function actionRun(){
        $this->start();
        $clients = [$this->_server];
        $history =[];
        do {
            $read =$clients;
            $write =null;
            $except =null;
            if (socket_select($read,$write,$except,null)>0){
                foreach ($read as $item){
                    if($item === $this->_server){
                        // 首次链接
                        if( $this->first($item,$clients) == false){continue;}
                    }else{
                        $result = @socket_recv($item,$msg,1024,0);
                        if($result === false) {continue;}
                        if ($result ===0 ){
                            $this->deleteClient($clients,$read,$result);
                        }else{
                            $response=$this->addHistory($msg,$history,$clients,$item);
                            // 广播
                            $this-> broadcast($clients,$read,$response);
                        }
                    }
                }
            }
        } while (true);
    }
}