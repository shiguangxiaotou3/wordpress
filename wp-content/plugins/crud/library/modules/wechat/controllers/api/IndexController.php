<?php
namespace crud\modules\wechat\controllers\api;


use Yii;
use crud\modules\market\controllers\api\ApiController;
class IndexController extends ApiController
{
    public $layout = false;

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex()
    {
        $wechat = Yii::$app->subscription;
         exit($wechat->ValidateServer());
    }

    /**
     * 接收微信消息,并回复
     */
    public function actionCreate()
    {
        return $this->success('ok',  Yii::$app->subscription->autoMessage());
    }



}