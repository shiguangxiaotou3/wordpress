<?php


namespace crud\modules\wechat\models;

use GuzzleHttp\Client;
use yii\base\BaseObject;
use GuzzleHttp\Exception\GuzzleException;








/**
 * Class SubscriptionServiceClient
 * @property Client $conn;
 * @package crud\common\model\weixin
 */
class SubscriptionServiceClient  extends BaseObject
{
    private $_conn;

    /**
     * @return Client
     */
    public function getConn(){
        return $this->_conn;
    }

    /**
     * @param $config
     */
    public function setConn($config){
        if(empty($config)){
            $config = [
                "timeout"=>10,
                // body‘,'json', 'query', 'form_params
                "body"=>"",
                "headers"=>[
                    "Accept"=>"application/json,application/xml,text/html,application/xhtml+xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
                    "Accept-Language"=> "zh-CN,zh;q=0.9,en;q=0.8",
                    "User-Agent"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36"
                ],

            ];
        }
        $this->_conn = new Client($config);
    }

    public function get($url ,$params=[]){
        $client =$this->conn;
        $str = [];
        foreach ($params as $key=> $value){
            $str[] =$key."=".$value;
        }
        try {
            return $client->request('GET', $url."?".join("&",$str));
        } catch (GuzzleException $e) {
            return false;
        }
    }

    public function getAccessToken($appid,$secret,$grant_type="client_credential"){
       return $this->get("https://api.weixin.qq.com/cgi-bin/token", getParams());

    }

}