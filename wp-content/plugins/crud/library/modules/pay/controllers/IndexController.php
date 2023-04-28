<?php
namespace crud\modules\pay\controllers;

use crud\modules\pay\models\Order;
use Yii;
use yii\web\Controller;
use crud\modules\pay\components\Alipay;
class IndexController extends Controller
{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index",'alibaba','wechat','reflect'
        ];
    }

    public function actionIndex(){
        return $this->render("index");
    }

    public function actionAlibaba(){
        return $this->render('alibaba');
    }

    /**
     * 获取微信平台证书
     * @return false|string
     */
    public function actionWechat(){
        if(Yii::$app->request->isAjax){
            return json_encode( Yii::$app->wechatPay->certificates());
        }
        return $this->render('wechat');
    }
    public function actionTest(){
        return $this->render('test');
    }

    /**
     * 转账
     * @return false|string
     * @throws Exception
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

    public function actionOrder(){
       $links=[
            ['url'=>'pay/index','label'=>'支付'],
            ['url'=>'pay/index/alibaba','label'=>'支付宝'],
            ['url'=>'pay/index/wechat','label'=>'微信支付'],
            ['url'=>'pay/index/test','label'=>'测试'],
            ['url'=>'pay/index/remit','label'=>'转账到支付宝'],
            ['url'=>'pay/index/order','label'=>'订单表'],
           ['url'=>'pay/index/reflect','label'=>'提现申请'],

       ];
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'pay/index/order',
            'title'=>'用户管理',
            'url_prefix'=>'pay',
            'links'=>json_encode($links),
            'tableName'=>'Order'
        ]);
    }


    public function actionReflect(){
        $links=[
            ['url'=>'pay/index','label'=>'支付'],
            ['url'=>'pay/index/alibaba','label'=>'支付宝'],
            ['url'=>'pay/index/wechat','label'=>'微信支付'],
            ['url'=>'pay/index/test','label'=>'测试'],
            ['url'=>'pay/index/remit','label'=>'转账到支付宝'],
            ['url'=>'pay/index/order','label'=>'订单表'],
            ['url'=>'pay/index/reflect','label'=>'提现申请'],

        ];
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'pay/index/reflect',
            'title'=>'用户管理',
            'url_prefix'=>'pay',
            'links'=>json_encode($links),
            'tableName'=>'Reflect'
        ]);
    }


}