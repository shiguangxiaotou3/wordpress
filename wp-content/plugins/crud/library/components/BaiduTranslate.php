<?php


namespace crud\components;

use Exception;
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
        $results = json_decode($ret, true);
        if(isset( $results['error_code'])){
            $message = self::error($results['error_code']);
            throw new Exception($message['message'].". ".$message['description']);
        }else{
            return  $results;
        }
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

    /**
     * @param $code
     * @return array|string
     */
    public static  function error($code){
        $errors=[
            ['code'=>52000,"message"=>"成功","description"=>""],
            ['code'=> 52001,"message"=>"请求超时","description"=>"请重试"],
            ['code'=> 52002,"message"=>"系统错误 ","description"=>"请重试"],
            ['code'=>52003,"message"=>"未授权用户 ","description"=>"请检查appid是否正确或者服务是否开通"],
            ['code'=> 54000 ,"message"=>"必填参数为空","description"=>"请检查是否少传参数"],
            ['code'=> 54001,"message"=>"签名错误","description"=>"请检查您的签名生成方法"],
            ['code'=> 54003 ,"message"=>"访问频率受限","description"=>"请降低您的调用频率，或进行身份认证后切换为高级版/尊享版"],
            ['code'=> 54004,"message"=>"账户余额不足","description"=>"请前往管理控制台为账户充值"],
            ['code'=>  54005,"message"=>"长query请求频繁","description"=>"请降低长query的发送频率，3s后再试"],
            ['code'=>  58000,"message"=>"客户端IP非法","description"=>"检查个人资料里填写的IP地址是否正确，可前往开发者信息-基本信息修改"],
            ['code'=> 58001 ,"message"=>"译文语言方向不支持","description"=>"检查译文语言是否在语言列表里"],
            ['code'=> 58002,"message"=>"服务当前已关闭 ","description"=>"请前往管理控制台开启服务"],
            ['code'=>90107  ,"message"=>"认证未通过或未生效","description"=>"请前往我的认证查看认证进度"],
        ];
        foreach ($errors as $error){
            if($code == $error["code"]){
                return $error;
            }
        }
        return '';
    }
}