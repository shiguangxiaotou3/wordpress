<?php
namespace crud\components;

use Exception;
use GuzzleHttp\Client;
use yii\base\BaseObject;
use GuzzleHttp\Exception\GuzzleException;


/**
 * 发送http请求
 * @package crud\components
 */
class Http extends BaseObject
{
    public $timeout='2.0';
    /**
     * @var Client
     */
    public $_client;

    public function __construct($base_uri=''){
        $this->_client = new Client([
            "base_uri"=>$base_uri,
            'timeout'=>$this->timeout
        ]);
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function get($uri, $options = [])
    {
        return $this->response($this->_client->get($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function post($uri, $options = [])
    {
        return $this->response($this->_client->post($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function delete($uri, $options = [])
    {
        return $this->response($this->_client->delete($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function head($uri, $options = [])
    {
        return $this->response($this->_client->head($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     */
    public function options($uri, $options = [])
    {
        return $this->response($this->_client->options($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function put($uri, $options = [])
    {
        return $this->response($this->_client->put($uri, $options));
    }

    /**
     * @param $uri
     * @param array $options
     * @return array|false|mixed|string
     * @throws GuzzleException
     */
    public function patch($uri, $options = [])
    {
        return $this->response($this->_client->patch($uri, $options));
    }

    /**
     * 解析响应结果
     * @param $response
     * @return array|false|mixed|string
     */
    public function response($response){
        try {
            if ($response->getStatusCode() == 200) {
                $types =$this->getResponseDataType($response->getHeader('content-type')[0]);
                $data =$response->getBody()->getContents();
                if(empty($data) or $data =="null" or $data =="NULL" ){
                    return '';
                }
                if( in_array('application/json',$types)){
                    return json_decode( $data,true);
                }elseif (in_array( "application/xml",$types)){
                    return  self::xmlParser($data);
                }else{
                    return  $data;
                }
            }
        }catch (Exception $exception){
            return false;
        }
    }

    /**
     * @param $contentType
     * @return false|string[]
     */
    public static function getResponseDataType($contentType){
        return explode("; ",$contentType);
    }

    /**
     * @return string[]
     */
    public static function ContentType(){
        return [
            "text/html", "text/plain", "text/css",
            "text/javascript", "image/jpeg", "image/png",
            "image/gif", "application/x-www-form-urlencoded",
            'application/zip',"application/pdf",
            'audio/mpeg',
            "multipart/form-data", "application/json", "application/xml"
        ];
}

    /**
     * 解析xml
     * @param $xml
     * @return array
     */
    public static function xmlParser($xml){
        $parameters = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $parameters =  (array) $parameters ;
        return $parameters === null ? [] : $parameters;
    }

}