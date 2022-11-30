<?php



namespace console\controllers;


use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 *  翻译控制台
 */
class TranslateController extends Controller
{


    /**
     * 翻译I18n 文件
     */
    public function actionI18n(){
        $translate = \Yii::$app->baidu;
        $path = \Yii::getAlias("@library/messages/city/zh-CN/city.php");
        $data = require_once $path;
        $result1 =$result2 =[];
        foreach ($data as $key =>$value){
            if(empty($value)){
                $result1[$key]="";
            }else{
                $result2[$key]=$value;
            }
        }
        $result1= $translate->translate( $result1);
        writeConfig($path, ArrayHelper::merge( $result1,$result2));
    }

    public function replace($str){
         $config =[
             "。"=>".",
             "（"=>"(",
             "）"=>")",
             "“"=>"\"",
             "”"=>"\"",
             "'"=>"\'",
             "？"=>"?"
         ];
         foreach ($config as $key =>$value){
             $str = str_replace($key,$value,$str);
         }
         return $str;
    }
}