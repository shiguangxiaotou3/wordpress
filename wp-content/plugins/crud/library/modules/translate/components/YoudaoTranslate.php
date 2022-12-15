<?php


namespace crud\modules\translate\components;


use crud\modules\translate\components\Translate;
use yii\base\Component;

class YoudaoTranslate extends Component implements Translate
{
    public $appId = "";
    public $appSecret = "";
    public $shortcut;
    public $url = "https://openapi.youdao.com/api";
    const CURL_TIMEOUT = 2000;

    /**
     * @param $data
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return array
     */
    public function Translate($data, $from = "auto", $to = "en", $format = "text", $model = "general")
    {

        $results = [];
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $results[$key] = $this->TranslateOne($key, $from, $to, $format, $model);
            }
        } else {
            $results = $this->TranslateOne($data, $from, $to, $format, $model);
        }
        return $results;
    }

    /**
     * @param $code
     * @return array
     */
    public static function error($code)
    {
        $data = [
            ['code' => 101, 'message' => '缺少必填的参数,首先确保必填参数齐全，然后确认参数书写是否正确。', 'description' => ''],
            ['code' => 102, 'message' => '不支持的语言类型', 'description' => ''],
            ['code' => 103, 'message' => '翻译文本过长', 'description' => ''],
            ['code' => 104, 'message' => '不支持的API类型', 'description' => ''],
            ['code' => 105, 'message' => '不支持的签名类型', 'description' => ''],
            ['code' => 106, 'message' => '不支持的响应类型', 'description' => ''],
            ['code' => 107, 'message' => '不支持的传输加密类型', 'description' => ''],
            ['code' => 108, 'message' => '应用ID无效，注册账号，登录后台创建应用并完成绑定，可获得应用ID和应用密钥等信息', 'description' => ''],
            ['code' => 109, 'message' => 'batchLog格式不正确', 'description' => ''],
            ['code' => 110, 'message' => '无相关服务的有效应用,应用没有绑定服务应用，可以新建服务应用。注：某些服务的翻译结果发音需要tts服务，需要在控制台创建语音合成服务绑定应用后方能使用。', 'description' => ''],
            ['code' => 111, 'message' => '开发者账号无效', 'description' => ''],
            ['code' => 112, 'message' => '请求服务无效', 'description' => ''],
            ['code' => 113, 'message' => 'q不能为空', 'description' => ''],
            ['code' => 114, 'message' => '不支持的图片传输方式', 'description' => ''],
            ['code' => 116, 'message' => 'strict字段取值无效，请参考文档填写正确参数值', 'description' => ''],
            ['code' => 201, 'message' => '解密失败，可能为DES,BASE64,URLDecode的错误', 'description' => ''],
            ['code' => 202, 'message' => '签名检验失败,如果确认应用ID和应用密钥的正确性，仍返回202，一般是编码问题。请确保翻译文本 q 为UTF-8编码.', 'description' => ''],
            ['code' => 203, 'message' => '访问IP地址不在可访问IP列表', 'description' => ''],
            ['code' => 205, 'message' => '请求的接口与应用的平台类型不一致，确保接入方式（Android SDK、IOS SDK、API）与创建的应用平台类型一致。如有疑问请参考入门指南', 'description' => ''],
            ['code' => 206, 'message' => '因为时间戳无效导致签名校验失败', 'description' => ''],
            ['code' => 207, 'message' => '重放请求', 'description' => ''],
            ['code' => 301, 'message' => '辞典查询失败', 'description' => ''],
            ['code' => 302, 'message' => '翻译查询失败', 'description' => ''],
            ['code' => 303, 'message' => '服务端的其它异常', 'description' => ''],
            ['code' => 304, 'message' => '会话闲置太久超时', 'description' => ''],
            ['code' => 308, 'message' => 'rejectFallback参数错误', 'description' => ''],
            ['code' => 309, 'message' => 'domain参数错误', 'description' => ''],
            ['code' => 310, 'message' => '未开通领域翻译服务', 'description' => ''],
            ['code' => 401, 'message' => '账户已经欠费，请进行账户充值', 'description' => ''],
            ['code' => 402, 'message' => 'offlinesdk不可用', 'description' => ''],
            ['code' => 411, 'message' => '访问频率受限,请稍后访问', 'description' => ''],
            ['code' => 412, 'message' => '长请求过于频繁，请稍后访问', 'description' => ''],
            ['code' => 1001, 'message' => '无效的OCR类型', 'description' => ''],
            ['code' => 1002, 'message' => '不支持的OCR image类型', 'description' => ''],
            ['code' => 1003, 'message' => '不支持的OCR Language类型', 'description' => ''],
            ['code' => 1004, 'message' => '识别图片过大', 'description' => ''],
            ['code' => 1201, 'message' => '图片base64解密失败', 'description' => ''],
            ['code' => 1301, 'message' => 'OCR段落识别失败', 'description' => ''],
            ['code' => 1411, 'message' => '访问频率受限', 'description' => ''],
            ['code' => 1412, 'message' => '超过最大识别字节数', 'description' => ''],
            ['code' => 2003, 'message' => '不支持的语言识别Language类型', 'description' => ''],
            ['code' => 2004, 'message' => '合成字符过长', 'description' => ''],
            ['code' => 2005, 'message' => '不支持的音频文件类型', 'description' => ''],
            ['code' => 2006, 'message' => '不支持的发音类型', 'description' => ''],
            ['code' => 2201, 'message' => '解密失败', 'description' => ''],
            ['code' => 2301, 'message' => '服务的异常', 'description' => ''],
            ['code' => 2411, 'message' => '访问频率受限,请稍后访问', 'description' => ''],
            ['code' => 2412, 'message' => '超过最大请求字符数', 'description' => ''],
            ['code' => 3001, 'message' => '不支持的语音格式', 'description' => ''],
            ['code' => 3002, 'message' => '不支持的语音采样率', 'description' => ''],
            ['code' => 3003, 'message' => '不支持的语音声道', 'description' => ''],
            ['code' => 3004, 'message' => '不支持的语音上传类型', 'description' => ''],
            ['code' => 3005, 'message' => '不支持的语言类型', 'description' => ''],
            ['code' => 3006, 'message' => '不支持的识别类型', 'description' => ''],
            ['code' => 3007, 'message' => '识别音频文件过大', 'description' => ''],
            ['code' => 3008, 'message' => '识别音频时长过长', 'description' => ''],
            ['code' => 3009, 'message' => '不支持的音频文件类型', 'description' => ''],
            ['code' => 3010, 'message' => '不支持的发音类型', 'description' => ''],
            ['code' => 3201, 'message' => '解密失败', 'description' => ''],
            ['code' => 3301, 'message' => '语音识别失败', 'description' => ''],
            ['code' => 3302, 'message' => '语音翻译失败', 'description' => ''],
            ['code' => 3303, 'message' => '服务的异常', 'description' => ''],
            ['code' => 3411, 'message' => '访问频率受限,请稍后访问', 'description' => ''],
            ['code' => 3412, 'message' => '超过最大请求字符数', 'description' => ''],
            ['code' => 4001, 'message' => '不支持的语音识别格式', 'description' => ''],
            ['code' => 4002, 'message' => '不支持的语音识别采样率', 'description' => ''],
            ['code' => 4003, 'message' => '不支持的语音识别声道', 'description' => ''],
            ['code' => 4004, 'message' => '不支持的语音上传类型', 'description' => ''],
            ['code' => 4005, 'message' => '不支持的语言类型', 'description' => ''],
            ['code' => 4006, 'message' => '识别音频文件过大', 'description' => ''],
            ['code' => 4007, 'message' => '识别音频时长过长', 'description' => ''],
            ['code' => 4201, 'message' => '解密失败', 'description' => ''],
            ['code' => 4301, 'message' => '语音识别失败', 'description' => ''],
            ['code' => 4303, 'message' => '服务的异常', 'description' => ''],
            ['code' => 4411, 'message' => '访问频率受限,请稍后访问', 'description' => ''],
            ['code' => 4412, 'message' => '超过最大请求时长', 'description' => ''],
            ['code' => 5001, 'message' => '无效的OCR类型', 'description' => ''],
            ['code' => 5002, 'message' => '不支持的OCR image类型', 'description' => ''],
            ['code' => 5003, 'message' => '不支持的语言类型', 'description' => ''],
            ['code' => 5004, 'message' => '识别图片过大', 'description' => ''],
            ['code' => 5005, 'message' => '不支持的图片类型', 'description' => ''],
            ['code' => 5006, 'message' => '文件为空', 'description' => ''],
            ['code' => 5201, 'message' => '解密错误，图片base64解密失败', 'description' => ''],
            ['code' => 5301, 'message' => 'OCR段落识别失败', 'description' => ''],
            ['code' => 5411, 'message' => '访问频率受限', 'description' => ''],
            ['code' => 5412, 'message' => '超过最大识别流量', 'description' => ''],
            ['code' => 9001, 'message' => '不支持的语音格式', 'description' => ''],
            ['code' => 9002, 'message' => '不支持的语音采样率', 'description' => ''],
            ['code' => 9003, 'message' => '不支持的语音声道', 'description' => ''],
            ['code' => 9004, 'message' => '不支持的语音上传类型', 'description' => ''],
            ['code' => 9005, 'message' => '不支持的语音识别 Language类型', 'description' => ''],
            ['code' => 9301, 'message' => 'ASR识别失败', 'description' => ''],
            ['code' => 9303, 'message' => '服务器内部错误', 'description' => ''],
            ['code' => 9411, 'message' => '访问频率受限（超过最大调用次数）', 'description' => ''],
            ['code' => 9412, 'message' => '超过最大处理语音长度', 'description' => ''],
            ['code' => 10001, 'message' => '无效的OCR类型', 'description' => ''],
            ['code' => 10002, 'message' => '不支持的OCR image类型', 'description' => ''],
            ['code' => 10004, 'message' => '识别图片过大', 'description' => ''],
            ['code' => 10201, 'message' => '图片base64解密失败', 'description' => ''],
            ['code' => 10301, 'message' => 'OCR段落识别失败', 'description' => ''],
            ['code' => 10411, 'message' => '访问频率受限', 'description' => ''],
            ['code' => 10412, 'message' => '超过最大识别流量', 'description' => ''],
            ['code' => 11001, 'message' => '不支持的语音识别格式', 'description' => ''],
            ['code' => 11002, 'message' => '不支持的语音识别采样率', 'description' => ''],
            ['code' => 11003, 'message' => '不支持的语音识别声道', 'description' => ''],
            ['code' => 11004, 'message' => '不支持的语音上传类型', 'description' => ''],
            ['code' => 11005, 'message' => '不支持的语言类型', 'description' => ''],
            ['code' => 11006, 'message' => '识别音频文件过大', 'description' => ''],
            ['code' => 11007, 'message' => '识别音频时长过长，最大支持30s', 'description' => ''],
            ['code' => 11201, 'message' => '解密失败', 'description' => ''],
            ['code' => 11301, 'message' => '语音识别失败', 'description' => ''],
            ['code' => 11303, 'message' => '服务的异常', 'description' => ''],
            ['code' => 11411, 'message' => '访问频率受限,请稍后访问', 'description' => ''],
            ['code' => 11412, 'message' => '超过最大请求时长', 'description' => ''],
            ['code' => 12001, 'message' => '图片尺寸过大', 'description' => ''],
            ['code' => 12002, 'message' => '图片base64解密失败', 'description' => ''],
            ['code' => 12003, 'message' => '引擎服务器返回错误', 'description' => ''],
            ['code' => 12004, 'message' => '图片为空', 'description' => ''],
            ['code' => 12005, 'message' => '不支持的识别图片类型', 'description' => ''],
            ['code' => 12006, 'message' => '图片无匹配结果', 'description' => ''],
            ['code' => 13001, 'message' => '不支持的角度类型', 'description' => ''],
            ['code' => 13002, 'message' => '不支持的文件类型', 'description' => ''],
            ['code' => 13003, 'message' => '表格识别图片过大', 'description' => ''],
            ['code' => 13004, 'message' => '文件为空', 'description' => ''],
            ['code' => 13301, 'message' => '表格识别失败', 'description' => ''],
            ['code' => 15001, 'message' => '需要图片', 'description' => ''],
            ['code' => 15002, 'message' => '图片过大（1M）', 'description' => ''],
            ['code' => 15003, 'message' => '服务调用失败', 'description' => ''],
            ['code' => 17001, 'message' => '需要图片', 'description' => ''],
            ['code' => 17002, 'message' => '图片过大（1M）', 'description' => ''],
            ['code' => 17003, 'message' => '识别类型未找到', 'description' => ''],
            ['code' => 17004, 'message' => '不支持的识别类型', 'description' => ''],
            ['code' => 17005, 'message' => '服务调用失败', 'description' => ''],];
        foreach ($data as $datum){
            if($datum['code'] == $code){
                return $datum;
            }
        }
        return  ['code' => 404, 'message' => '未知的错误'];
    }

    /**
     * @return string[]
     */
    public function languages()
    {
        return [
            'auto'=>'自动识别',
            'zh-CHS'=>'中文',
            'zh-CHT'=>'中文繁体',
            'en'=>'英文',
            'ja'=>'日文',
            'ko'=>'韩文',
            'fr'=>'法文',
            'es'=>'西班牙文',
            'pt'=>'葡萄牙文',
            'it'=>'意大利文',
            'ru'=>'俄文',
            'vi'=>'越南文',
            'de'=>'德文',
            'ar'=>'阿拉伯文',
            'id'=>'印尼文',
            'af'=>'南非荷兰语',
            'bs'=>'波斯尼亚语',
            'bg'=>'保加利亚语',
            'yue'=>'粤语',
            'ca'=>'加泰隆语',
            'hr'=>'克罗地亚语',
            'cs'=>'捷克语',
            'da'=>'丹麦语',
            'nl'=>'荷兰语',
            'et'=>'爱沙尼亚语',
            'fj'=>'斐济语',
            'fi'=>'芬兰语',
            'el'=>'希腊语',
            'ht'=>'海地克里奥尔语',
            'he'=>'希伯来语',
            'hi'=>'印地语',
            'mww'=>'白苗语',
            'hu'=>'匈牙利语',
            'sw'=>'斯瓦希里语',
            'tlh'=>'克林贡语',
            'lv'=>'拉脱维亚语',
            'lt'=>'立陶宛语',
            'ms'=>'马来语',
            'mt'=>'马耳他语',
            'no'=>'挪威语',
            'fa'=>'波斯语',
            'pl'=>'波兰语',
            'otq'=>'克雷塔罗奥托米语',
            'ro'=>'罗马尼亚语',
            'sr-Cyrl'=>'塞尔维亚语(西里尔文)',
            'sr-Latn'=>'塞尔维亚语(拉丁文)',
            'sk'=>'斯洛伐克语',
            'sl'=>'斯洛文尼亚语',
            'sv'=>'瑞典语',
            'ty'=>'塔希提语',
            'th'=>'泰语',
            'to'=>'汤加语',
            'tr'=>'土耳其语',
            'uk'=>'乌克兰语',
            'ur'=>'乌尔都语',
            'cy'=>'威尔士语',
            'yua'=>'尤卡坦玛雅语',
            'sq'=>'阿尔巴尼亚语',
            'am'=>'阿姆哈拉语',
            'hy'=>'亚美尼亚语',
            'az'=>'阿塞拜疆语',
            'bn'=>'孟加拉语',
            'eu'=>'巴斯克语',
            'be'=>'白俄罗斯语',
            'ceb'=>'宿务语',
            'co'=>'科西嘉语',
            'eo'=>'世界语',
            'tl'=>'菲律宾语',
            'fy'=>'弗里西语',
            'gl'=>'加利西亚语',
            'ka'=>'格鲁吉亚语',
            'gu'=>'古吉拉特语',
            'ha'=>'豪萨语',
            'haw'=>'夏威夷语',
            'is'=>'冰岛语',
            'ig'=>'伊博语',
            'ga'=>'爱尔兰语',
            'jw'=>'爪哇语',
            'kn'=>'卡纳达语',
            'kk'=>'哈萨克语',
            'km'=>'高棉语',
            'ku'=>'库尔德语',
            'ky'=>'柯尔克孜语',
            'lo'=>'老挝语',
            'la'=>'拉丁语',
            'lb'=>'卢森堡语',
            'mk'=>'马其顿语',
            'mg'=>'马尔加什语',
            'ml'=>'马拉雅拉姆语',
            'mi'=>'毛利语',
            'mr'=>'马拉地语',
            'mn'=>'蒙古语',
            'my'=>'缅甸语',
            'ne'=>'尼泊尔语',
            'ny'=>'齐切瓦语',
            'ps'=>'普什图语',
            'pa'=>'旁遮普语',
            'sm'=>'萨摩亚语',
            'gd'=>'苏格兰盖尔语',
            'st'=>'塞索托语',
            'sn'=>'修纳语',
            'sd'=>'信德语',
            'si'=>'僧伽罗语',
            'so'=>'索马里语',
            'su'=>'巽他语',
            'tg'=>'塔吉克语',
            'ta'=>'泰米尔语',
            'te'=>'泰卢固语',
            'uz'=>'乌兹别克语',
            'xh'=>'南非科萨语',
            'yi'=>'意第绪语',
            'yo'=>'约鲁巴语',
            'zu'=>'南非祖鲁语',

        ];
    }

    /**
     * @param $str
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return mixed|string
     */
    public function TranslateOne($str, $from = "auto", $to = "en", $format = "text", $model = "general")
    {
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
        $signStr = $this->appId . $this->truncate($str) . $salt . $curtime . $this->appSecret;
        $args['sign'] = hash("sha256", $signStr);
        $args['vocabId'] = $model;
        $results = json_decode($this->call($this->url, $args), true);
        if($results['errorCode'] ==0){
            return $results["translation"][0];
        }else{
            $data = self::error($results['errorCode']);
            throw new Exception($data['message'],$data['code']);
        }
    }

    public function model(){
        return [
            "general" => '通用（默认取值）',
            "computers" => '计算机',
            "medicine" => '医学',
            "finance" => '金融经济',
        ];
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
     * @param int $timeout
     * @param array $headers
     * @return bool|string
     */
    private function callOnce($url, $args = null, $method = "post", $withCookie = false, $timeout = self::CURL_TIMEOUT, $headers = array())
    {
        $ch = curl_init();
        if ($method == "post") {
            $data = $this->convert($args);
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
     * @return string
     */
    private function create_guid()
    {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);
        $dec_hex = dechex($a_dec * 1000000);
        $sec_hex = dechex($a_sec);
        $this->ensure_length($dec_hex, 5);
        $this->ensure_length($sec_hex, 6);
        $guid = "";
        $guid .= $dec_hex;
        $guid .= $this->create_guid_section(3);
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
    private function create_guid_section($characters)
    {
        $return = "";
        for ($i = 0; $i < $characters; $i++) {
            $return .= dechex(mt_rand(0, 15));
        }
        return $return;
    }

    /**
     * @param $q
     * @return string
     */
    private function truncate($q)
    {
        $len = $this->abslength($q);
        return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
    }

    /**
     * @param $str
     * @return false|int
     */
    private function abslength($str)
    {

        if (empty($str)) {
            return 0;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'utf-8');
        } else {
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

    /**
     * @return mixed
     */
    public function shortcut()
    {
        return $this->shortcut;
    }

}