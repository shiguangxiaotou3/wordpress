<?php


namespace crud\modules\pay\controllers;

use Yii;
use yii\web\Controller;
use crud\modules\pay\components\Alipay;



class IndexController extends Controller
{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index",'alibaba'
        ];
    }

    public function actionIndex(){
        return $this->render("index");
    }

    public function actionAlibaba(){
        return $this->render('alibaba');
    }

    public function actionTest(){
        return $this->render('test');
    }

    /**
     * 转账
     * @return string
     */
    public function actionRemit(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $user = wp_get_current_user();
            if($user->ID ==1){
                /** @var Alipay $alipay  */
                $alipay = Yii::$app->alipay;
                $response = $alipay->remit(
                    "test_remit" . time(),
                    $request->post('orderMoney'),
                    $request->post('toUser'),
                    $request->post('toUserName'),
                    $request->post('orderTitle'),
                    $request->post('orderRemark'));
                if (!empty($response->code) && $response->code == 10000) {
                    return json_encode(['code'=>1,"message"=>$response->msg,"data"=>$response]);
                }else{
                    return json_encode(['code'=>0,"message"=>$response->sub_msg,"data"=>$response]);
                }

//                return json_encode(['code'=>1,"message"=>"你没有权限","data"=>$data]);
            }else{
                return json_encode(['code'=>0,"message"=>"你没有权限"]);
            }
        }
        return $this->render('remit');
    }
}