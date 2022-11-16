<?php


namespace crud\components;

use Yii;
use yii\web\Request;
use yii\base\Component;
use Google\Cloud\Translate\V2\TranslateClient;

/**
 * Class TranslateController
 * @property TranslateClient $translate
 * @package ShiGuangXiaoTou\controllers
 */
class Translate extends Component{

    public $_translate;
    public $translateKey;

    public function getTranslate(){
        if(isset($this->_translate)){
            return $this->_translate;
        }else{

        }
    }

    public function setTranslate($key){
        $this->_translate = new TranslateClient(["key"=>$this->translateKey]);
    }

    /***
     * ISO 639-1 语言代码列表
     */
    public function actionLanguages(){
        $cache = Yii::$app->cache;
        if(!$cache->get("iso")){
            $languages = $this->translate->languages();
            $iso=[];
            foreach ($languages as $language) {
                $iso[]= $language;
            }
            $cache->set("iso",$iso);
        }
        return $cache->get("iso");
    }

    /**
     * 获取支持的语言
     */
    public function actionLanguagesInfo(){
        $cache = Yii::$app->cache;
        if(!$cache->get("languageInfo")){
            $translate = new TranslateClient(["key"=>$this->key]);
            $languages = $this->translate->localizedLanguages();
            $results =[];
            foreach ($languages as $language) {
                $results []= $language;
            }
            $cache->set("languageInfo",$results );
        }
        return $cache->get("languageInfo");
    }

    /**
     * 检测语言
     * @param $text
     */
    public function actionDetectLanguage($text){
        return $this->translate->detectLanguage(
            $text
        );
    }

    /**
     * 批量检测语言
     * @param array $text
     */
    public function actionDetectLanguages($text=[]){
        return $this->translate->detectLanguageBatch(
          $text
        );

    }

    /**
     * translate
     */
    public function actionTranslate()
    {
        /** @var  $require Request */
        $require = Yii::$app->request;
        $data = json_decode( $require->rawBody,true);
        $source = isset($data['source']) ? $data['source'] : "";
        $target = isset($data['target']) ? $data['target'] : "zh-CN";
        $format = isset($data['format']) ? $data['format'] : "text";
        $model = isset($data['model']) ? $data['model'] : "";
        if (isset($data["str"]) and !empty($data["str"])) {
            if (is_array($data['str'])) {
                return $this->translate->translateBatch($data["str"],[
                    "source" => $source,
                    "target" => $target,
                    "format" => $format,
                    "model" => $model
                ]);
            } else {
                return $this->translate->translate($data["str"], [
                    "source" => $source,
                    "target" => $target,
                    "format" => $format,
                    "model" => $model
                ]);
            }

        }else{
            return "str不能为空，或数据格式不正确";
        }

    }
}