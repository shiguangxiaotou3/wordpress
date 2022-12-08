<?php


namespace crud;

use Yii;
use GuzzleHttp\Client;
use yii\web\Response;

/**
 * @property Application $app
 * @package crud
 */
class Base  {

    /**
     * @param $data
     */
    public static function sendHtml($data){
        $response= Yii::$app->response;
        $response->format =Response::FORMAT_HTML;
        $response->data = $data;
        $response->send();
    }

    /**
     * @param $data
     */
    public static function sendJson($data){
        $response= Yii::$app->response;
        $response->format =Response::FORMAT_JSON;
        $response->data = $data;
        $response->send();
    }

    /**
     * @param $data
     */
    public static function sendJsonp($data){
        $response= Yii::$app->response;
        $response->format =Response::FORMAT_JSONP;
        $response->data = $data;
        $response->send();
    }

    /**
     * @param $data
     */
    public static function sendRaw($data){
        $response= Yii::$app->response;
        $response->format =Response::FORMAT_RAW;
        $response->data = $data;
        $response->send();
    }

    /**
     * @param $data
     */
    public static function sendXml($data){
        $response= Yii::$app->response;
        $response->format =Response::FORMAT_XML;
        $response->data = $data;
        $response->send();
    }

    /**
     * @param $filePath
     * @param null $attachmentName
     * @param array $options
     */
    public static function sendFile($filePath, $attachmentName = null, $options = []){
        $response= Yii::$app->response;
        $response->sendFile($filePath, $attachmentName = null, $options = []);
    }

    /**
     * @param $message
     * @param string $data
     * @param int $code
     */
    public static function error($message,$data='',$code=0){
        self::sendJson(["code"=>$code, "message"=>$message, 'data'=>$data, "time"=>time()]);
    }

    /**
     * @param $message
     * @param string $data
     * @param int $code
     */
    public static function success($message,$data='',$code=1){
        self::sendJson(["code"=>$code, "message"=>$message, 'data'=>$data, "time"=>time()]);
    }


    public static function GET($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->get($url);
    }

    public static function POST($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->request('POST',$url,$data);
    }
    public static function PUT($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->request('PUT',$url,$data);
    }
    public static function PATCH($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->request('PATCH',$url,$data);
    }
    public static function HEAD($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->request('HEAD',$url,$data);
    }
    public static function OPTIONS($url,$data){
        $client = new Client(['timeout'  => 2.0]);
        return $client->request('OPTIONS',$url,$data);
    }
}