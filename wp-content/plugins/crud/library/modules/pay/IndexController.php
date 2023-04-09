<?php
namespace crud\modules\pay\controllers\api;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{

    /**
     * 创建订单
     */
    public function actionSubmit(){

    }
    /**
     * 订单查询
     */
    public function actionSelect(){

    }

    /**
     * 订单关闭
     */
    public function actionClose(){

    }

    /**
     * 订单退款
     */
    public function actionRefund(){

    }

    /**
     *
     */
    public function actionRefundSelect(){

    }

    /**
     * 异步通知
     */
    public function actionNotify(){
        $alipay = Yii::$app->alipay;
//        $data =[
//            "gmt_create" => "2023-03-18 20:30:35",
//            "charset" => "utf-8",
//            "gmt_payment" => "2023-03-18 20:30:40",
//            "notify_time" => "2023-03-18 20:30:41",
//            "subject" => "test",
//            "sign" => "QH36qhWnL1f72rmPHD0nKBuoKwl+oTHadv5CS+UnfSrH/H90nZ+YLt7GvyLpFa1sjnc3GjWqkUKt53vyyRGqUrhwlhNaF7DrlVDecsrpLDvWKz6Rlvye3XfJiz2Fz05onR2JyZv9o9VQA0H/AgwjRiA+rxPJ0DVKzoUgJvNUR5YWQj3WEkmJT9ZOuBgKrxB8h9TL2EMYq7R9mz6xHeYJamuZYnnOb4y0vk5AKH350lajICvmXpVDBtaBZM9S2T4gdA4toqraklsUBb1TSc3KXaTHN/MQirzK2Hp+eF4JZwMOpbaPsVoGweR+oluW6RppTcv96TnDptetvvXxGMq4Gw==",
//            "buyer_id" => "2088802586317273",
//            "invoice_amount" => "0.01",
//            "version" => "1.0",
//            "notify_id" => "2023031801222203041017271402610479",
//            "fund_bill_list" =>  '[{"amount":"0.01","fundChannel":"PCREDIT"}]',
//            "notify_type" => "trade_status_sync",
//            "out_trade_no" => "test_2023_03_171679142630",
//            "total_amount" => "0.01",
//            "trade_status" => "TRADE_SUCCESS",
//            "trade_no" => "2023031822001417271410041691",
//            "auth_app_id" => "2021003178650132",
//            "receipt_amount" => " 0.01",
//            "point_amount" => "0.00",
//            "buyer_pay_amount" => "0.01",
//            "app_id" => "2021003178650132",
//            "sign_type" => "RSA2",
//            "seller_id" => "2088441708358398"
//        ];
//       echo mb_detect_encoding(json_encode($data), array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
//       die();
        if($alipay-> checkSign(  $_POST)){
            //logObject(['code'=>'成功',"post"=> $_POST]);
            wp_mail(['757402123@qq.com'],"阿里异步通知",print_r(["验证成功", $_POST],true));
            exit("success");
        }else{
            //logObject(['code'=>'成功',"post"=> $_POST]);
            wp_mail(['757402123@qq.com'],"阿里异步通知",print_r(["验证失败",  $_POST],true));
            exit("error");
        }
    }


}