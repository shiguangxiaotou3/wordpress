<?php
namespace crud\controllers;

use Yii;
use yii\web\Controller;
use crud\models\wp\WpUsers;

/**
 * @property-read WpUsers $user
 */
class ApiController extends Controller
{

    public $_user;

    public function getUser(){
//        header("Access-Control-Allow-Origin:*");
        if(isset($this->_user)){
            return $this->_user;
        }else{
            $data =Yii::$app->request->headers;
            $token = $data['token'];
            if($user =(new WpUsers())->getUserByToken($token)){
                $this->_user = (new WpUsers())->getUserByToken($token);
                return $this->_user;
            }else{
                return false;
            }

        }

    }

    public function error($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 0,
            'message' => $message,
            'time' => time(),
            'data' => $data
        ]);
    }

    public function success($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 1,
            'message' => $message,
            'time' => time(),
            'data' => $data,
        ]);
    }

    public function Auth(){
//        wp_set_auth_cookie();
//        wp_clear_auth_cookie();
    }

    public function json($data){
        header('Content-Type: application/json');
        return json_encode($data);
    }

    public function html($data){
        header('Content-Type: application/json');
        return (string) $data;
    }

    public function yida($apiMethod,$requestParams){
        $timestamp = (string)intval(microtime(1) * 1000);
        $sign_Array = [
            "privateKey" =>get_option('crud_group_market_express_yida_privateKey'),
            "timestamp"  => $timestamp,
            "username"   =>  get_option('crud_group_market_express_yida_username'),
        ];
        $sign  = strtoupper(MD5(json_encode($sign_Array,320)));

        $body = [
            "apiMethod"        => $apiMethod,
            "businessParams"   => $requestParams,
            "sign"             => $sign,
            "timestamp"        => $timestamp,
            "username"         => get_option('crud_group_market_express_yida_username'),
        ];
        $header = ["Content-Type:application/json"];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.yida178.cn");
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body,320));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }
}