<?php


namespace crud\modules\seo\components;


use crud\modules\translate\components\Translate;
use yii\base\Component;

class BaiduSeo extends Component implements SeoInterface
{
    public $token ='If9vjjXOhqDg46Es';
    public $uri ='http://data.zz.baidu.com/urls';


    /**
     * @param $urls
     * @return mixed|void
     */
    public function send($urls){
        $api = $this->getUrl();
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->uri.$this->getQuery();
    }

    /**
     * @param $options
     * @return string
     */
    public function getQuery($options=[]){
        return "?". http_build_query([
                "site"=>'www.shiguangxiaotou.com',
                'token'=> $this->token,
            ]);
    }
}