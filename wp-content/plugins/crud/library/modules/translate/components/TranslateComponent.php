<?php


namespace crud\modules\translate\components;


use yii\base\Component;
use Yii;
class TranslateComponent extends Component{

    public $type =self::BAIDU;
    const GOOGLE ="google";
    const YOUDAO ='youdao';
    const BAIDU ='baidu';
    const MICROSOFT ='microsoft';

    public function translate($data,$from ="",$to="",$format = "text", $model = ""){
        try {
            $type = $this->type;
            $data = Yii::$app->$type->translate($data, $from, $to, $format, $model);

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

    public function getLanguages(){
        $type =$this->type;
        return Yii::$app->$type->languages();
    }
    public function getShortcut(){
        $type =$this->type;
        return Yii::$app->$type->shortcut();
    }
}