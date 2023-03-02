<?php


namespace crud\modules\base\controllers\api;

use Yii;
use yii\web\Controller;

class IndexController  extends Controller
{

    public function actionIndex(){


    }

    public function actionCreate(){
        $request =Yii::$app->request;
        $ips = $request->post("ips");
        $ips = explode(",",$ips);
        $crawlers = Yii::$app->crawlers;
        $results =[];
        foreach ($ips as $ip){
            $re =$crawlers->getIpinfo($ip);
            $results[] = [
                "latLng" => explode(",", $re["loc"]),
                "name" => Yii::t("city", $re["city"])
            ];
        }
        return  $results;

    }
}