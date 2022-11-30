<?php


namespace crud\components;


use yii\base\Component;

class BaiduTranslate extends Component{
    public $url = "http://api.fanyi.baidu.com/api/trans/vip/translate";
    public $appId = "";
    public $appSecret = "";
    const CURL_TIMEOUT = 10;

    /**
     * @param $data
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return array
     */
    public function translate($data,$from ="en",$to="zh",$format = "text", $model = ""){
        $results =[];
        if (is_array( $data)){
            $str =join("\n",array_keys($data));
            $results =$this->TranslateOne($str,$from,$to,$format,$model);
            $tmp_results=[];
            if($results["trans_result"]){
                foreach ($results["trans_result"] as $result){
                    $tmp_results[$result['src']]=$result['dst'];
                }
            }
            return   $tmp_results;
        }else{
            $results =$this->TranslateOne($data,$from,$to,$format,$model);
        }
        return $results;
    }

    /**
     * @param $str
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return mixed
     */
    public function translateOne($str, $from ="en",$to="zh",$format = "text", $model = ""){

        $args = array(
            'q' => $str,
            'appid' => $this->appId,
            'salt' => rand(10000, 99999),
            'from' => $from,
            'to' => $to,
        );
        $args['sign'] = $this->buildSign($str, $this->appId, $args['salt'], $this->appSecret);
        $ret = $this->call($this->url, $args);
         return json_decode($ret, true);
    }

    /**
     * 加密
     * @param $query
     * @param $appID
     * @param $salt
     * @param $secKey
     * @return string
     */
    public function buildSign($query, $appID, $salt, $secKey)
    {
        $str = $appID . $query . $salt . $secKey;
        return md5($str);

    }

    /**
     * 发起网络请求
     * @param $url
     * @param null $args
     * @param string $method
     * @param int $testflag
     * @param $timeout
     * @param array $headers
     * @return false|mixed
     */
    private function call($url, $args = null, $method = "post", $testflag = 0, $timeout = self::CURL_TIMEOUT, $headers = array())
    {
        $ret = false;
        $i = 0;
        while ($ret === false) {
            if ($i > 1)
                break;
            if ($i > 0) {
                sleep(1);
            }
            $ret = $this->callOnce($url, $args, $method, false, $timeout, $headers);
            $i++;
        }
        return $ret;
    }

    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param false $withCookie
     * @param $timeout
     * @param array $headers
     * @return bool|string
     */
    private function callOnce($url, $args = null, $method = "post", $withCookie = false, $timeout = self::CURL_TIMEOUT, $headers = array())
    {
        $ch = curl_init();
        if ($method == "post") {
            $data =$this-> convert($args);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            $data = $this->convert($args);
            if ($data) {
                if (stripos($url, "?") > 0) {
                    $url .= "&$data";
                } else {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ($withCookie) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
        }
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

    /**
     * @param $args
     * @return string
     */
    private function convert(&$args)
    {
        $data = '';
        if (is_array($args)) {
            foreach ($args as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $data .= $key . '[' . $k . ']=' . rawurlencode($v) . '&';
                    }
                } else {
                    $data .= "$key=" . rawurlencode($val) . "&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }

}