<?php

namespace crud\modules\wechat\controllers;

use Yii;
use crud\controllers\ApiController;
class TemplateMessageController extends ApiController
{

    /**
     * @return false|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionList(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            return $this->success('success',$subscription->templateList);
        }
        return $this->error('error');
    }

    public function actionSend(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            $data= Yii::$app->request->post();
            $return_url=[];
            $template_id=$data['message']['template_id'];
            if($data['message']['template_id']){
                $return_url =['template_id'=>$data['message']['template_id']];
            }
            if($data['message']['url']){
                $return_url=['url'=>$data['message']['url']];
            }

            $openid=$data['message']['touser'];
            $data=$data['message']['data'];
            return $this->success('success',
                $subscription->sendTemplateMessage($template_id,$openid,$data,$return_url)
            );
        }
        $this->error('error');
    }
    public function actionDelete(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            return $this->success('success',$_POST);
        }
    }
}