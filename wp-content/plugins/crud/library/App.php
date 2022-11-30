<?php


namespace crud;

use yii\base\BaseObject;
use yii\web\Response;

/**
 * @property Application $app
 * @package crud
 */
class App extends  BaseObject {

    /**
     * @param $data
     */
    public function sendJson($data){
        header("Content-Type:application/json; charset=utf-8");
        exit(json_encode($data,true));
    }

    /**
     * @param $data
     */
    public function sendXml($data){
       $response= Yii::$app->response;
       $response->format =Response::FORMAT_XML;
       $response->data = $data;
       $response->send();
    }

    /**
     * @param $message
     * @param string $data
     * @param int $code
     */
    public function error($message,$data='',$code=0){
        $this->sendJson(["code"=>$code, "message"=>$message, 'data'=>$data, "time"=>time()]);
    }

    /**
     * @param $message
     * @param string $data
     * @param int $code
     */
    public function success($message,$data='',$code=1){
        $this->sendJson(["code"=>$code, "message"=>$message, 'data'=>$data, "time"=>time()]);
    }
}