<?php


namespace api\controllers;


use crud\models\wechat\ValidateServer;
use yii\web\Controller;
use Yii;
class WechatController extends Controller{


    /**
     * 开发者认证
     * @return bool
     */
    public function actionIndex(){

        $params = Yii::$app->request->get();
        $params["token"]=Yii::$app->wechat->token;
        $model = new ValidateServer($params);
        if($model->validate() && $model->checkSignature()){
            exit($model->echostr);
        }else{

          echo  json_encode( $model->getErrors());
        }
    }

    public function actionTest(){
        echo json_encode(["dasda","asdas"]);
    }


    public function send(){

    }


    /**
     * @param $message
     * @param $data
     * @param int $code
     */
    public function success($message,$data,$code = 1){
        $response =  Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = [
            'success' => $response->isSuccessful,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        $response->statusCode = 200;
        $response->send();

    }

    public function error($message,$data,$code = 0){
        $response =  Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = [
            'success' => $response->isSuccessful,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        $response->statusCode = 200;
        $response->send();
    }


}