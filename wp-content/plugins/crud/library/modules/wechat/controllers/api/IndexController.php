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
        wp_mail(
            '757402123@qq.com',
            "微信服务器验证",
            print_r(['get'=>$_GET,'post'=>$_POST],true)
        );
        $wechat = Yii::$app->subscription;
         exit($wechat->ValidateServer());
    }

    /**
     * 接收微信消息,并回复
     */
    public function actionCreate()
    {
//        $data = Yii::$app->request->post();
//        wp_mail('757402123@qq.com','测试',print_r($data ,true));
        Yii::$app->subscription->autoMessage();
//        return $this->success('ok', );
    }
}