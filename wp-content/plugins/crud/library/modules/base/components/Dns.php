<?php


namespace crud\modules\base\components;

use Exception;
use yii\base\Component;
use AlibabaCloud\Tea\Utils\Utils;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\SDK\Alidns\V20150109\Alidns;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\AddDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\OperateBatchDomainRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\UpdateDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainLogsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainInfoRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainStatisticsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordInfoRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeRecordStatisticsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainStatisticsSummaryRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeRecordStatisticsSummaryRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\OperateBatchDomainRequest\domainRecordInfo;





/**
 * 阿里云云解析接口
 *
 *
 * @property $client
 * @property $domains
 * @package app\base
 */
class Dns extends Component
{
    public $_client;
    public $lang = "zh_CN";
    public $accessKeyId = "";
    public $accessKeySecret = "";


    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Alidns
     */
    public static function createClient($accessKeyId = '', $accessKeySecret = '')
    {

        try{
            $config = new Config([
                "accessKeyId" => $accessKeyId,
                "accessKeySecret" => $accessKeySecret,
                'credential'=>false
            ]);
            $config->protocol ="HTTP";
            // 访问的域名
            $config->endpoint = "alidns.cn-hangzhou.aliyuncs.com";
            return new Alidns($config);
        }catch (Exception $exception){

        }

    }

    /**
     * @return Alidns
     */
    public function getClient(){
        try {
            if(!empty($this->accessKeyId)  and !empty( $this->accessKeySecret)){
                if (!isset($this->_client)) {
                    $this->_client = self::createClient($this->accessKeyId, $this->accessKeySecret);
                }
                return $this->_client;
            }
        }catch (Exception $exception){
            return false;
        }
    }

    /**
     * @return bool
     */
    public function getDomains()
    {
        $client =$this->client;
        if($client){
            $describeDomainsRequest = new DescribeDomainsRequest(["lang" => $this->lang,]);
            $request =$client->describeDomainsWithOptions($describeDomainsRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
                $items = $request->body->domains->domain;
                $data =[];
                foreach ($items as $domain){
                    $data[] = get_object_vars($domain);
                }
                foreach ($data as $key =>$domain){
                    unset($data[$key]["dnsServers"]);
                    unset($data[$key]["tags"]);
                }
                return  $data;
            }
        }
    }

    /**
     * @param $domain
     * @return mixed
     */
    public function getDomainInfo($domain)
    {
        $client =$this->client;
        if($client){
            $describeDomainInfoRequest = new DescribeDomainInfoRequest(["lang" => $this->lang, "domainName" => $domain]);
            $request =$client->describeDomainInfoWithOptions(
                $describeDomainInfoRequest,
                new RuntimeOptions([])
            );
            if($request->statusCode ==200){
                return  get_object_vars($request->body);
            }
        }

    }

    /**
     * 获取操作日志
     * @param $domain
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainLogsResponse|bool
     */
    public function getDomainActionLog($domain = "")
    {
        $client =$this->client;
        if($client){
            $describeDomainLogsRequest = new DescribeDomainLogsRequest(
                ["lang" => $this->lang, "domainName" => $domain]
            );
            $request =$this->client->describeDomainLogsWithOptions($describeDomainLogsRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
                $data =[];
                foreach ($request->body->domainLogs->domainLog as $domainLog){
                    $data[] =  get_object_vars($domainLog);
                }
                return  $data;
            }
        }


    }

    /**
     * 获取解析列表
     * @param $domain
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordsResponse|bool
     */
    public function getDomainRecordList($domain)
    {
        $client =$this->client;
        if($client){
            $describeDomainRecordsRequest = new DescribeDomainRecordsRequest([
                "lang" => $this->lang,
                "domainName" => $domain
            ]);
            $request = $client->describeDomainRecordsWithOptions($describeDomainRecordsRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
                $data =[];
                foreach ($request->body->domainRecords->record as $domainLog){
                    $data[] =  get_object_vars($domainLog);
                }
                return  $data;
            }
        }
    }

    /**
     * 添加解析记录
     * @param $domain
     * @param $rr
     * @param $value
     * @param string $type
     * @return AlibabaCloud\SDK\Alidns\V20150109\Models\AddDomainRecordResponse|bool
     */
    public function AddDomainRecord($domain, $rr, $value, $type = "A")
    {

        if($this->client){
            $addDomainRecordRequest = new AddDomainRecordRequest([
            "lang" => $this->lang,
            "domainName" => $domain,
            "RR" => $rr,
            "type" => "A",
            "value" => $value
        ]);
            $request = $this->client->addDomainRecordWithOptions($addDomainRecordRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
            return  get_object_vars($request->body);
        }
        }

    }

    /**
     * 删除解析记录
     * @param $recordId
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteDomainRecordResponse|bool
     */
    public function DeleteDomainRecordById($recordId)
    {
        if($this->client) {

            $deleteDomainRecordRequest = new DeleteDomainRecordRequest([
                "lang" => $this->lang,
                "recordId" => $recordId
            ]);
            $request = $this->client->deleteDomainRecordWithOptions($deleteDomainRecordRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                return get_object_vars($request->body);
            } else {
                return false;
            }
        }

    }

    /**
     * 删除解析记录通过RR值
     * @param $domain
     * @param $rr
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteSubDomainRecordsResponse|bool
     */
    public function DeleteDomainRecordsByRr($domain, $rr)
    {
        if($this->client) {
            $deleteSubDomainRecordsRequest = new DeleteDomainRecordRequest([
                "lang" => $this->lang,
                "domainName" => $domain,
                "RR" => $rr
            ]);
            $request = $this->client->deleteSubDomainRecordsWithOptions($deleteSubDomainRecordsRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                return $request->body;
            } else {

                return false;
            }
        }
    }

    /**
     * 获取解析记录详细信息
     * @param $recordId
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordInfoResponse|bool
     */
    public function getDomainRecordInfoById($recordId)
    {
        if($this->client) {
            $describeDomainRecordInfoRequest = new DescribeDomainRecordInfoRequest([
                "lang" => $this->lang,
                "recordId" => $recordId
            ]);
            $request =  $this->client->describeDomainRecordInfoWithOptions($describeDomainRecordInfoRequest,new RuntimeOptions([]));
            if($request->statusCode ==200){
                return   get_object_vars($request->body);
            }else{
                return  false;
            }
        }
    }

    /**
     * 修改解析记录
     * @param $RecordId
     * @param $rr
     * @param $value
     * @param string $type
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\UpdateDomainRecordResponse|bool
     */
    public function UpdateDomainRecord($RecordId, $rr, $value, $type = "A")
    {
        if($this->client) {
            $updateDomainRecordRequest = new UpdateDomainRecordRequest([
                "recordId" => $RecordId,
                "RR" =>  $rr,
                "value" => $value,
                "type" => $type,
                "lang" => $this->lang,
            ]);
            $request = $this->client->updateDomainRecordWithOptions($updateDomainRecordRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
                return   $request->body;
            }else{
                return  false;
            }
        }
    }

    /**
     * 批量操作域名或解析记录
     * @param $type DOMAIN_ADD|DOMAIN_DEL|RR_ADD|RR_DEL
     * ~~~
     * $data =[
     *  [
     *      "type"=>"A",
     *      "domain" => "shigaungxiaotou.com",
     *      "rr" => "www",
     *      "value" => "192.168.1.1",
     *      "newRr" =>"",
     *      "newType" =>"",
     *      "newValue"=>""
     *  ],
     * [
     *      "type"=>"A",
     *      "domain" => "shigaungxiaotou.com",
     *      "rr" => "www",
     *      "value" => "192.168.1.1",
     *      "newRr" =>"",
     *      "newType" =>"",
     *      "newValue"=>""
     *  ]
     * ]
     * ~~~
     * @param array $data
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\OperateBatchDomainResponse|bool
     */
    public function BatchDomain($type, $data = [])
    {
        $client =$this->client;
        if($this->client){
            $domainRecordInfo = [];
            foreach ($data as $datum) {
                $domainRecordInfo[] = new   domainRecordInfo($datum);
            }
            $operateBatchDomainRequest = new   OperateBatchDomainRequest([
                "lang" => $this->lang,
                "domainRecordInfo" => $domainRecordInfo,
                "type" => $type
            ]);
            $request = $this->client->operateBatchDomainWithOptions($operateBatchDomainRequest, new RuntimeOptions([]));
            if($request->statusCode ==200){
                return   $request->body;
            }else{
                return  false;
            }
        }
    }

    /**
     * 获取主域名的请求量统计
     * @param $domain
     * @param $StartDate
     * @param string $EndDate
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainStatisticsResponse|bool
     */
    public function getDomainVisit($domain, $StartDate, $EndDate = "")
    {
        $client =$this->client;
        if($this->client){
            $describeDomainStatisticsRequest = new DescribeDomainStatisticsRequest([
                "lang" => $this->lang,
                "domainName" => $domain,
                "startDate" => $StartDate,
                "endDate" => empty($EndDate) ? date("Y-m-d") : $EndDate
            ]);
            $request = $this->client->describeDomainStatisticsWithOptions($describeDomainStatisticsRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                if(isset($request->body->statistics->statistic) and !empty($request->body->statistics->statistic)){
                    $data =[];
                    foreach ($request->body->statistics->statistic as $item){
                        $data[] = get_object_vars($item);
                    }
                    return   $data ;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * 获取全部域名的请求量统计
     * @param $StartDate
     * @param $EndDate
     * @return AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainStatisticsSummaryResponse|bool
     */
    public function getDomainVisitAll($StartDate, $EndDate = "")
    {
        if($this->client){
            $describeDomainStatisticsSummaryRequest = new DescribeDomainStatisticsSummaryRequest([
                "lang" => $this->lang,
                "startDate" => $StartDate,
                "endDate" => empty($EndDate) ? date("Y-m-d") : $EndDate
            ]);
            $request = $this->client->describeDomainStatisticsSummaryWithOptions($describeDomainStatisticsSummaryRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                if(isset($request->body->statistics->statistic) and !empty($request->body->statistics->statistic)){
                    $data =[];
                    foreach ($request->body->statistics->statistic as $item){
                        $data[] = get_object_vars($item);
                    }
                    return   $data ;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * 获取子域名请求记录
     * @param $domain
     * @param $RR
     * @param $StartDate
     * @param string $EndDate
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeRecordStatisticsResponse|bool
     */
    public function getDomainChildrenVisit($domain, $RR, $StartDate, $EndDate = "")
    {
        if($this->client){
            $describeRecordStatisticsRequest = new DescribeRecordStatisticsRequest([
                "domainName" => $domain,
                "rr" => $RR,
                "startDate" => $StartDate,
                "endDate" => empty($EndDate) ? date("Y-m-d") : $EndDate
            ]);
            $request = $this->client->describeRecordStatisticsWithOptions($describeRecordStatisticsRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                if(isset($request->body->statistics->statistic) and !empty($request->body->statistics->statistic)){
                    $data =[];
                    foreach ($request->body->statistics->statistic as $item){
                        $data[] = get_object_vars($item);
                    }
                    return   $data ;
                }

            } else {
                return false;
            }}

    }

    /**
     * 获取全部子域名请求记录
     * @param $domain
     * @param $StartDate
     * @param string $EndDate
     * @return \AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeRecordStatisticsSummaryResponse
     */
    public function getDomainChildrenVisitAll($domain, $StartDate, $EndDate = "")
    {
        if($this->client){
            $describeRecordStatisticsSummaryRequest = new DescribeRecordStatisticsSummaryRequest([
                "lang" => $this->lang,
                "domainName" => $domain,
                "startDate" => $StartDate,
                "endDate" => empty($EndDate) ? date("Y-m-d") : $EndDate
            ]);
            $request = $this->client->describeRecordStatisticsSummaryWithOptions($describeRecordStatisticsSummaryRequest, new RuntimeOptions([]));
            if ($request->statusCode == 200) {
                if(isset($request->body->statistics->statistic) and !empty($request->body->statistics->statistic)){
                    $data =[];
                    foreach ($request->body->statistics->statistic as $item){
                        $data[] = get_object_vars($item);
                    }
                    return   $data ;
                }
            } else {
                return false;
            }
        }

    }


}