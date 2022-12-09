<?php


namespace crud\modules\translate\components;


use yii\base\Component;
use Yii;
class TranslateComponent extends Component{

    public $type =self::BAIDU;
    const GOOGLE ="google";
    const YOUDAO ='youdao';
    const BAIDU ='baidu';

    public function translate($data,$from ="",$to="",$format = "text", $model = ""){
        try {
            $type =$this->type;
            if($type =="youdao"){
                $data =Yii::$app->$type->translate($data,$from ,$to,$format , $model );
            }else{
                $data =Yii::$app->$type->translate($data,$from ,$to,$format , $model );
            }

            return [
                'code'=>1,
                'message'=>'ok',
                "data"=>$data,
            ];
        }catch (Exception $exception){
            return [
                'code'=>0,
                'message'=>"error:".$exception->getCode().". ". $exception->getMessage(),
                'time'=>time(),
                'data'=>'',
            ];
        }
    }


    public function getlanguage(){
        $type =$this->type;
        return Yii::$app->$type->language();
    }
}