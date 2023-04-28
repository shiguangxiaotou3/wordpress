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
        header("Access-Control-Allow-Origin:*");
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
        wp_set_auth_cookie();
        wp_clear_auth_cookie();
    }

    public function json($data){
        header('Content-Type: application/json');
        return json_encode($data);
    }

    public function html($data){
        header('Content-Type: application/json');
        return (string) $data;
    }
}