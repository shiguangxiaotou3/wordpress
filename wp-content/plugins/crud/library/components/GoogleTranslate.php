<?php


namespace crud\components;

use Yii;
use yii\web\Request;
use yii\base\Component;
use Google\Cloud\Translate\V2\TranslateClient;

/**
 * Class TranslateController
 * @property TranslateClient $client
 * @package ShiGuangXiaoTou\controllers
 */
class GoogleTranslate extends Component
{

    public $_translate;
    public $translateKey;

    public function getClient()
    {
        if (!isset($this->_translate) or !empty($this->_translate)) {
            $this->setTranslate();
        }
        return $this->_translate;
    }

    public function setTranslate()
    {
        $this->_translate = new TranslateClient(["key" => $this->translateKey]);
    }

    /***
     * ISO 639-1 语言代码列表
     */
    public function languages()
    {
        $cache = Yii::$app->cache;
        if (!$cache->get("iso")) {
            $languages = $this->client->languages();
            $iso = [];
            foreach ($languages as $language) {
                $iso[] = $language;
            }
            $cache->set("iso", $iso);
        }
        return $cache->get("iso");
    }

    /**
     * 获取支持的语言
     */
    public function languagesInfo()
    {
        $cache = Yii::$app->cache;
        if (!$cache->get("languageInfo")) {
            $languages = $this->client->localizedLanguages();
            $results = [];
            foreach ($languages as $language) {
                $results [] = $language;
            }
            $cache->set("languageInfo", $results);
        }
        return $cache->get("languageInfo");
    }

    /**
     * 检测语言
     * @param $text
     */
    public function detectLanguage($text)
    {
        return $this->client->detectLanguage(
            $text
        );
    }

    /**
     * 批量检测语言
     * @param array $text
     */
    public function detectLanguages($text = [])
    {
        return $this->client->detectLanguageBatch(
            $text
        );

    }

    /**
     * @param array|string $data
     * @param string $form
     * @param string $to
     * @param string $format
     * @param string $model
     * @return array|null
     */
    public function translate($data, $form = "en", $to = "zh-CN", $format = "text", $model = "")
    {
        if (is_array($data)) {
            return $this->client->translateBatch($data["str"], [
                "source" => $form,
                "target" => $to,
                "format" => $format,
                "model" => $model
            ]);
        } else {
            return $this->client->translate($data, [
                "source" => $form,
                "target" => $to,
                "format" => $format,
                "model" => $model
            ]);
        }
    }
}