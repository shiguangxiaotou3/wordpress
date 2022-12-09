<?php


namespace crud\modules\translate\controllers\api;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex(){
        $data = Yii::$app->request ->get('data');
        $from = Yii::$app->request ->get('from');
        $to = Yii::$app->request ->get('to');
        $format = Yii::$app->request ->get('format');
        $model = Yii::$app->request ->get('model');
        return Yii::$app->translate->translate( $data,$from ,$to,$format , $model);
    }
}