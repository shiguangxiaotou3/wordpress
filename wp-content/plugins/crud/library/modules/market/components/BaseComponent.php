<?php
namespace crud\modules\market\components;

use Yii;
use yii\base\BaseObject;
use crud\components\Http;
use Darabonba\OpenApi\Models\Config;
use GuzzleHttp\Exception\GuzzleException;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\AddSmsTemplateRequest;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\QuerySmsTemplateListRequest;
/**
 *
 * @property string $appId
 * @property string $appSecret
 * @property string $token
 * @property Http $client
 * @property $menu
 * @property-read string $accessToken
 * @property-read string $ticket
 * Class BaseComponent
 * @package crud\modules\market\components
 */
class BaseComponent extends BaseObject
{
    /**
     * @param $phone
     * @param $code
     * @param $templateCode
     * @return bool
     */
    public function sendSms($phone,$code='',$templateCode =''){
        if(empty($code)){
            $code = rand(100000, 999999);
        }
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $phone,
            "signName" =>get_option("crud_group_market_sms_signName"),
            "templateCode" => get_option("crud_group_market_sms_templateCode"),
            "templateParam" => json_encode(['code'=>$code])
        ]);
        $response =$this->smsClient()->sendSmsWithOptions($sendSmsRequest, new RuntimeOptions([]));
        if($response->body->code =="OK" ){
            return true;
        }
        return false;
    }

    /**
     * 快递查询
     * @param $number
     * @return false|string
     */
    public function express($number){
        $AppCode =get_option("crud_group_market_express_AppCode");
        $url = "https://jmexpresv2.market.alicloudapi.com/express/query-v2";
        $headers = ["Authorization:APPCODE " . $AppCode,"Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8"];
        $data =[
            "expressCode"=>"",
            "mobile"=>"",
            "number"=>$number,
        ];
        return httpPost($url,$data,$headers);

    }

    /**
     * 快递单号识别
     * @param $number
     * @return false|string
     */
    public function expressDiscern($number){
        $AppCode =get_option("crud_group_market_express_AppCode");
        $url = "https://jmexpresv2.market.alicloudapi.com/express/number-discern";
        $headers = ["Authorization:APPCODE " .  $AppCode ,"Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8"];
        $data =[
            "number"=>$number,
        ];
        return httpPost($url,$data,$headers);
    }

    /**
     * @param $name
     * @param $content
     * @param $remark
     * @param int $type
     * @return mixed
     */
    public function addSmsTemplate($name,$content,$remark,$type=0){
        $addSmsTemplateRequest = new AddSmsTemplateRequest([
            "templateType" => $type,
            "templateName" => $name,
            "templateContent" => $content,
            "remark" => $remark
        ]);
        return  $this->smsClient()->addSmsTemplateWithOptions($addSmsTemplateRequest,new RuntimeOptions([]));
    }

    /**
     * @return Dysmsapi
     */
    public function smsClient(){
        $config = new Config([
            "accessKeyId" => get_option("crud_group_market_sms_accessKeyId"),
            "accessKeySecret" => get_option("crud_group_market_sms_accessKeySecret")
        ]);

        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }

    /**
     * 查询模版列表
     * @return mixed
     */
    public function selectTemplateList()
    {
        $res = [];
        $response  = $this->smsClient()->querySmsTemplateListWithOptions(new QuerySmsTemplateListRequest([]), new RuntimeOptions([]));
        if($response->statusCode ==200){
            foreach ( $response->body->smsTemplateList as $item){
                $arr = json_decode(json_encode($item), true);
                $config = [
                    'AUDIT_STATE_INIT' => '审核中。',
                    'AUDIT_STATE_PASS' => '审核通过',
                    'AUDIT_STATE_NOT_PASS' => '审核未通过，请在返回参数Reason中查看审核未通过原因',
                    'AUDIT_STATE_CANCEL' => '取消审核'];
                $arr['auditStatusText'] = $config[$arr['auditStatus']];
                array_push($res, $arr);
            }

        }
        return $res;
    }
}