<?php


namespace crud\components;


use yii\base\Component;

class YoudaoTranslate extends Component
{
    public $appId="";
    public $appSecret ="";
    public $url ="https://openapi.youdao.com/api";
    const CURL_TIMEOUT =2000;

    /**
     * @param $data
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return array
     */
    public function Translate($data,$from ="en",$to="zh-CHS",$format = "text", $model = ""){
        $results =[];
        if (is_array( $data)){
            foreach ($data as $key =>$value){
                $results[$key]= $this->TranslateOne($key,$from,$to,$format,$model);
            }
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
     * @return mixed|string
     */
    public function TranslateOne($str,$from ="en",$to="zh-CHS",$format = "text", $model = ""){
        $salt = $this->create_guid();
        $args = array(
            'q' => $str,
            'appKey' => $this->appId,
            'salt' => $salt,
        );
        $args['from'] = $from;
        $args['to'] = $to;
        $args['signType'] = 'v3';
        $curtime = strtotime("now");
        $args['curtime'] = $curtime;
        $signStr = $this->appId . $this-> truncate($str) . $salt . $curtime . $this->appSecret;
        $args['sign'] = hash("sha256", $signStr);
        $args['vocabId'] = $model;
        $results  =json_decode($this-> call($this->url, $args),true);
        if(isset($results["translation"][0])){
            return replaceSymbol($results["translation"][0]);
        }else{
            return '';
        }
    }

    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param int $testflag
     * @param int $timeout
     * @param array $headers
     * @return bool|mixed|string
     */
    private function call($url, $args=null, $method="post", $testflag = 0, $timeout = self::CURL_TIMEOUT, $headers=array())
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
     * @param int $timeout
     * @param array $headers
     * @return bool|string
     */
    private function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = self::CURL_TIMEOUT, $headers=array())
    {
        $ch = curl_init();
        if($method == "post")
        {
            $data = $this->convert($args);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            $data =  $this->convert($args);
            if($data)
            {
                if(stripos($url, "?") > 0)
                {
                    $url .= "&$data";
                } else {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($headers))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($withCookie)
        {
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
        if (is_array($args))
        {
            foreach ($args as $key=>$val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k=>$v)
                    {
                        $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                    }
                } else {
                    $data .="$key=".rawurlencode($val)."&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }

    /**
     * @return string
     */
    private function create_guid(){
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);
        $dec_hex = dechex($a_dec* 1000000);
        $sec_hex = dechex($a_sec);
        $this->ensure_length($dec_hex, 5);
        $this->ensure_length($sec_hex, 6);
        $guid = "";
        $guid .= $dec_hex;
        $guid .= $this-> create_guid_section(3);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= $this->create_guid_section(6);
        return $guid;
    }

    /**
     * @param $characters
     * @return string
     */
    private function create_guid_section($characters){
        $return = "";
        for($i = 0; $i < $characters; $i++)
        {
            $return .= dechex(mt_rand(0,15));
        }
        return $return;
    }

    /**
     * @param $q
     * @return string
     */
    private function truncate($q) {
        $len = $this->abslength($q);
        return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
    }

    /**
     * @param $str
     * @return false|int
     */
    private function abslength($str)
    {

        if(empty($str)){
            return 0;
        }
        if(function_exists('mb_strlen')){
            return mb_strlen($str,'utf-8');
        }
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }

    /**
     * @param $string
     * @param $length
     */
    private function ensure_length(&$string, $length)
    {
        $strlen = strlen($string);
        if ($strlen < $length) {
            $string = str_pad($string, $length, "0");
        } else if ($strlen > $length) {
            $string = substr($string, 0, $length);
        }
    }
}