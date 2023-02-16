<?php


namespace crud\modules\translate\components;

use Yii;
use yii\base\Component;

/**
 * Class MicrosoftTranslate
 * @package crud\modules\translate\components
 */
class MicrosoftTranslate extends Component implements Translate
{
    public $key ;
    public $location;
    public $shortcut;
    public $uli ="https://api.cognitive.microsofttranslator.com";


    public function translate($data, $from = "en", $to = "zh-Hans", $format = "text", $model = ""){
        $result = $request =[];
        if (is_array($data)){
            foreach (array_keys($data) as $key){
                $result[$key]="";
                $request[] =['text'=>$key];
            }
        }else{
            $result[$data]="";
            $request[] =['text'=>$data];
        }
        $request_json =json_encode($request);
        $options = array (
            'http' => array (
                'header' => $this->getHeader( $request_json),
                'method' => 'POST',
                'content' => $request_json
            )
        );
        $context  = stream_context_create ($options);
        $path =$this->uli . "/translate". $this->getQuery($from,$to);
        $response = file_get_contents ( $path, false, $context);
        $code =explode(" " ,$http_response_header[0])[1];
        if ($code !=200){
            $error = $this->httpError();
            throw new Exception($error[$code],$code);
        }else{
            $tmp =  json_decode($response,true);
            $i=0;
            foreach ($result as $key =>$value){
                $result[$key] = $tmp[$i]['translations'][0]['text'];
                $i++;
            }
            return $result;
        }
    }

    /**
     * @param $content
     * @return string
     */
    public function getHeader($content){
        $herder =[
            "Content-type"=>"application/json",
            "Content-length"=>strlen($content),
            "Ocp-Apim-Subscription-Key"=>$this->key,
            "X-ClientTraceId"=>$this->uuid(),
            "Ocp-Apim-Subscription-Region"=>$this->location
        ];
        $str ='';
        foreach ($herder as $key =>$value){
            $str .="$key: ".$value."\r\n";
        }
        return $str;
    }

    /**
     * @param $from
     * @param $to
     * @return string
     */
    public function getQuery($from,$to){
       return "?". http_build_query([
            'api-version'=> '3.0',
            'from'=> $from,
            'to'=>  $to,
        ]);
    }

    /**
     * @param $code
     * @return array
     */
    public static function error($code)
    {
        $data= [
            ['code' => 101, 'message' => '缺少必填的参数,首先确保必填参数齐全，然后确认参数书写是否正确。', 'description' => ''],
            ['code' => 400000, 'message' => '某个请求输入无效.', 'description' => ''],
            ['code' => 400001, 'message' => '“scope”参数无效.', 'description' => ''],
            ['code' => 400002, 'message' => '\'category\'参数无效.', 'description' => ''],
            ['code' => 400003, 'message' => '语言说明符缺失或无效.', 'description' => ''],
            ['code' => 400004, 'message' => '目标脚本说明符(\'To script\')缺失或无效。', 'description' => ''],
            ['code' => 400005, 'message' => '输入文本缺失或无效。', 'description' => ''],
            ['code' => 400006, 'message' => '语言和脚本的组合无效。', 'description' => ''],
            ['code' => 400018, 'message' => '源脚本说明符(\'From script\')缺失或无效。', 'description' => ''],
            ['code' => 400019, 'message' => '指定的某个语言不受支持。', 'description' => ''],
            ['code' => 400020, 'message' => '输入文本数组中的某个元素无效.', 'description' => ''],
            ['code' => 400021, 'message' => 'API 版本参数缺失或无效.', 'description' => ''],
            ['code' => 400023, 'message' => '指定的某个语言对无效.', 'description' => ''],
            ['code' => 400035, 'message' => '源语言(\'From\'字段)无效.', 'description' => ''],
            ['code' => 400036, 'message' => '目标语言(\'To”字段)缺失或无效.', 'description' => ''],
            ['code' => 400042, 'message' => '指定的某个选项(\'Options\'字段)无效.', 'description' => ''],
            ['code' => 400043, 'message' => '客户端跟踪ID(ClientTraceId字段或X-ClientTranceId标头)缺失或无效.', 'description' => ''],
            ['code' => 400050, 'message' => '输入文本过长.查看请求限制.', 'description' => ''],
            ['code' => 400064, 'message' => '\'translation\'参数缺失或无效.', 'description' => ''],
            ['code' => 400070, 'message' => '目标脚本(ToScript参数)的数目与目标语言(To参数)的数目不匹配.', 'description' => ''],
            ['code' => 400071, 'message' => 'TextType 的值无效.', 'description' => ''],
            ['code' => 400072, 'message' => '输入文本的数组包含过多的元素.', 'description' => ''],
            ['code' => 400073, 'message' => '脚本参数无效.', 'description' => ''],
            ['code' => 400074, 'message' => '请求正文是无效的JSON.', 'description' => ''],
            ['code' => 400075, 'message' => '语言对和类别组合无效.', 'description' => ''],
            ['code' => 400077, 'message' => '超过了最大请求大小. 查看请求限制.', 'description' => ''],
            ['code' => 400079, 'message' => '请求用于在源语言与目标语言之间进行翻译的自定义系统不存在.', 'description' => ''],
            ['code' => 400080, 'message' => '语言或脚本不支持音译.', 'description' => ''],
            ['code' => 401000, 'message' => '由于凭据缺失或无效,请求未授权.', 'description' => ''],
            ['code' => 401015, 'message' => '“提供的凭据适用于语音API.此请求需要文本API的凭据.请使用 Translator 的订阅。”', 'description' => ''],
            ['code' => 403000, 'message' => '不允许执行该操作.', 'description' => ''],
            ['code' => 403001, 'message' => '由于订阅已超过其免费配额,因此不允许该操作.', 'description' => ''],
            ['code' => 405000, 'message' => '请求的资源不支持该请求方法.', 'description' => ''],
            ['code' => 408001, 'message' => '正在准备所请求的翻译系统.请在几分钟后重试。', 'description' => ''],
            ['code' => 408002, 'message' => '等待传入流时请求超时.客户端没有在服务器准备等待的时间内生成请求。 客户端可以在以后的任何时间重复该请求，而不做任何修改。', 'description' => ''],
            ['code' => 415000, 'message' => 'Content-Type 标头缺失或无效.', 'description' => ''],
            ['code' => 429000, 'message' => '由于客户端已超出请求限制,服务器拒绝了请求.', 'description' => ''],
            ['code' => 429001, 'message' => '由于客户端已超出请求限制,服务器拒绝了请求.', 'description' => ''],
            ['code' => 429002, 'message' => '由于客户端已超出请求限制,服务器拒绝了请求.', 'description' => ''],
            ['code' => 500000, 'message' => '发生了意外错误.如果该错误持续出现,请报告发生错误的日期/时间、响应标头X-RequestId中的请求标识符,以及请求标头X-ClientTraceId中的客户端标识符。', 'description' => ''],
            ['code' => 503000, 'message' => '服务暂时不可用.Retry.如果该错误持续出现,请报告发生错误的日期/时间、响应标头X-RequestId中的请求标识符,以及请求标头X-ClientTraceId 中的客户端标识符.', 'description' => ''],
        ];
        foreach ($data as $datum){
            if($datum['code'] == $code){
                return $datum;
            }
        }
        return  ['code' => 404, 'message' => '未知的错误'];
    }

    /**
     * @param string $language
     * @return array|mixed
     */
    public function languages($language = "zh-Hans"){
       $cache = Yii::$app->cache;
       $languages = $cache->get("microsoft_languages");
       if(empty($languages)){
           $options = array (
               'http' => array (
                   'header' => "Accept-Language: ".$language,
                   'method' => 'GET',
               )
           );
           $context  = stream_context_create ($options);
           $path =$this->uli . "/languages?api-version=3.0";
           $languages = json_decode( file_get_contents ( $path , false, $context),true);
            $result=[];
            foreach ($languages['translation'] as $code=> $language){
                $result[$code]=$language['name'];
            }
           $cache->set("microsoft_languages",$result);
            return $result;
       }else{
           return  $languages;
       }
    }

    /**
     * @return string[]
     */
    public  function httpError(){
        return [
            200 => '成功.',
            400 => '查询参数之一缺失或无效,请更正请求参数，然后重试.',
            401 => '无法对请求进行身份验证,请确保凭据已指定且有效.',
            403 => '请求未授权,请检查详细错误消息.该状态代码通常表示试用订阅提供的所有可用翻译已用完.',
            408 => '无法满足请求,因为缺少资源.请检查详细错误消息.当请求包含自定义类别时，此状态代码通常表示自定义翻译系统尚不可用于为请求提供服务.应在等待一段时间(例如1分钟)后重试此请求.',
            429 => '由于客户端已超出请求限制.服务器拒绝了请求.',
            500 => '发生了意外错误,如果该错误持续出现.请报告发生故障的日期和时间、响应头\'X-RequestId\'中的请求标识符，以及请求头\'X-ClientTraceId\'中的客户端标识符.',
            503 => '服务器暂不可用,重试请求.如果该错误持续出现,请报告发生故障的日期和时间、响应头“X-RequestId”中的请求标识符,以及请求头“X-ClientTraceId”中的客户端标识符.',
        ];
    }

    /**
     * @return string
     */
    private function uuid(){
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * @return mixed
     */
    public function shortcut()
    {
        return $this->shortcut;
    }
}


