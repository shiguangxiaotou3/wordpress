<?php


namespace crud\modules\translate\components;


use Exception;
use yii\base\Component;
use crud\modules\translate\components\Translate;

class BaiduTranslate extends Component implements Translate
{
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
    public function translate($data,$from ="auto",$to="en",$format = "text", $model = ""){
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
            throw new Exception("Error:".$results['error_code'].". ".$message['message'].". ".$message['description']);
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
        return ['code'=>0  ,"message"=>"未知错误","description"=>""];
    }

    public function language()
    {
        return [
            'auto'=>"自动检测",
            'zh'=>'中文(简体)',
            'en'=>'英语',
            'afr'=>'南非荷兰语',
            'alb'=>'阿尔巴尼亚语',
            'amh'=>'阿姆哈拉语',
            'ara'=>'阿拉伯语',
            'arg'=>'阿拉贡语',
            'arm'=>'亚美尼亚语',
            'arq'=>'阿尔及利亚阿拉伯语',
            'aym'=>'艾马拉语',
            'aze'=>'阿塞拜疆语',
            'bak'=>'巴什基尔语',
            'bal'=>'俾路支语',
            'baq'=>'巴斯克语',
            'bel'=>'白俄罗斯语',
            'bem'=>'本巴语',
            'ber'=>'柏柏尔语',
            'bho'=>'博杰普尔语',
            'bli'=>'比林语',
            'bul'=>'保加利亚语',
            'cat'=>'加泰罗尼亚语',
            'chv'=>'楚瓦什语',
            'cos'=>'科西嘉语',
            'dan'=>'丹麦语',

            'epo'=>'世界语',
            'est'=>'爱沙尼亚语',
            'fao'=>'法罗语',
            'fra'=>'法语',
            'gla'=>'盖尔语',
            'gle'=>'爱尔兰语',
            'grn'=>'瓜拉尼语',
            'guj'=>'古吉拉特语',
            'hak'=>'哈卡钦语',
            'hau'=>'豪萨语',
            'hil'=>'希利盖农语',
            'hkm'=>'高棉语',
            'hu'=>'匈牙利语',
            'ibo'=>'伊博语',
            'ice'=>'冰岛语',
            'ina'=>'因特语',
            'it'=>'意大利语',
            'jp'=>'日语',
            'kab'=>'卡拜尔语',
            'kah'=>'卡舒比语',
            'kas'=>'克什米尔语',
            'kir'=>'吉尔吉斯语',
            'kli'=>'克林贡语',
            'kor'=>'韩语',
            'lag'=>'拉特加莱语',
            'lat'=>'拉丁语',
            'lin'=>'林加拉语',
            'log'=>'低地德语',
            'mah'=>'马绍尔语',
            'mau'=>'毛里求斯克里奥尔语',
            'may'=>'马来语',
            'mg'=>'马拉加斯语',
            'mlt'=>'马耳他语',
            'nno'=>'新挪威语',
            'nor'=>'挪威语',
            'nya'=>'齐切瓦语',
            'ori'=>'奥里亚语',
            'orm'=>'奥罗莫语',
            'oss'=>'奥塞梯语',
            'per'=>'波斯语',
            'pl'=>'波兰语',
            'pt'=>'葡萄牙语',
            'pus'=>'普什图语',
            'roh'=>'罗曼什语',
            'ru'=>'俄语',
            'ruy'=>'卢森尼亚语',
            'san'=>'梵语',
            'sha'=>'掸语',
            'slo'=>'斯洛文尼亚语',
            'sme'=>'北方萨米语',
            'sna'=>'修纳语',
            'som'=>'索马里语',
            'spa'=>'西班牙语',
            'srd'=>'萨丁尼亚语',
            'srp'=>'塞尔维亚语',
            'sun'=>'巽他语',
            'tam'=>'泰米尔语',
            'tel'=>'泰卢固语',
            'th'=>'泰语',
            'ukr'=>'乌克兰语',
            'ven'=>'文达语',
            'yue'=>'中文(粤语)',

            'zul'=>'祖鲁语',
            'tso'=>'聪加语',
            'de'=>'德语',
            'tet'=>'德顿语',
            'fil'=>'菲律宾语',
            'fri'=>'弗留利语',
            'kon'=>'刚果语',
            'kal'=>'格陵兰语',
            'gra'=>'古希腊语',
            'nl'=>'荷兰语',
            'ht'=>'海地语',
            'glg'=>'加利西亚语',
            'cs'=>'捷克语',
            'kan'=>'卡纳达语',
            'cor'=>'康瓦尔语',
            'cre'=>'克里克语',
            'hrv'=>'克罗地亚语',
            'kok'=>'孔卡尼语',
            'lao'=>'老挝语',
            'lav'=>'拉脱维亚语',
            'lug'=>'卢干达语',
            'kin'=>'卢旺达语',
            'ro'=>'罗姆语',
            'bur'=>'缅甸语',
            'mal'=>'马拉雅拉姆语',
            'mai'=>'迈蒂利语',
            'mao'=>'毛利语',
            'hmn'=>'苗语',
            'nea'=>'那不勒斯语',
            'sot'=>'南索托语',
            'pan'=>'旁遮普语',
            'twi'=>'契维语',
            'swe'=>'瑞典语',
            'sm'=>'萨摩亚语',
            'sol'=>'桑海语',
            'nob'=>'书面挪威语',
            'swa'=>'斯瓦希里语',
            'tr'=>'土耳其语',
            'tgl'=>'他加禄语',
            'tua'=>'突尼斯阿拉伯语',
            'wln'=>'瓦隆语',
            'wol'=>'沃洛夫语',
            'heb'=>'希伯来语',
            'fry'=>'西弗里斯语',
            'los'=>'下索布语',
            'nqo'=>'西非书面语',
            'ceb'=>'宿务语',
            'hi'=>'印地语',
            'vie'=>'越南语',
            'ach'=>'亚齐语',
            'ido'=>'伊多语',
            'iku'=>'伊努克提图特语',
            'cht'=>'中文(繁体)',
            'zaz'=>'扎扎其语',
            'jav'=>'爪哇语',
            'oci'=>'奥克语',
            'aka'=>'阿肯语',
            'asm'=>'阿萨姆语',
            'ast'=>'阿斯图里亚斯语',
            'oji'=>'奥杰布瓦语',
            'bre'=>'布列塔尼语',
            'pot'=>'巴西葡萄牙语',
            'pam'=>'邦板牙语',
            'ped'=>'北索托语',
            'bis'=>'比斯拉马语',
            'bos'=>'波斯尼亚语',
            'tat'=>'鞑靼语',
            'div'=>'迪维希语',
            'fin'=>'芬兰语',
            'ful'=>'富拉尼语',
            'ups'=>'高地索布语',
            'geo'=>'格鲁吉亚语',
            'eno'=>'古英语',
            'hup'=>'胡帕语',
            'mot'=>'黑山语',
            'frn'=>'加拿大法语',
            'kau'=>'卡努里语',
            'xho'=>'科萨语',
            'cri'=>'克里米亚鞑靼语',
            'que'=>'克丘亚语',
            'kur'=>'库尔德语',
            'rom'=>'罗马尼亚语',
            'lim'=>'林堡语',
            'ltz'=>'卢森堡语',
            'lit'=>'立陶宛语',
            'loj'=>'逻辑语',
            'mar'=>'马拉地语',
            'mac'=>'马其顿语',
            'glv'=>'曼克斯语',
            'ben'=>'孟加拉语',
            'nbl'=>'南恩德贝莱语',
            'nep'=>'尼泊尔语',
            'pap'=>'帕皮阿门托语',
            'chr'=>'切罗基语',
            'sec'=>'塞尔维亚-克罗地亚语',
            'sin'=>'僧伽罗语',
            'sk'=>'斯洛伐克语',
            'src'=>'塞尔维亚语（西里尔）',
            'tgk'=>'塔吉克语',
            'tir'=>'提格利尼亚语',
            'tuk'=>'土库曼语',
            'wel'=>'威尔士语',
            'urd'=>'乌尔都语',
            'el'=>'希腊语',
            'sil'=>'西里西亚语',
            'haw'=>'夏威夷语',
            'snd'=>'信德语',
            'syr'=>'叙利亚语',
            'id'=>'印尼语',
            'yid'=>'意第绪语',
            'ing'=>'印古什语',
            'yor'=>'约鲁巴语',
            'ir'=>'伊朗语',
            'wyw'=>'中文(文言文)',
            'frm'=>'中古法语',
        ];
    }
}