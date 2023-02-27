<?php


namespace crud\modules\sms\components;

use yii\base\Component;
use crud\modules\sms\models\ErrorCodes;
use crud\modules\sms\models\RequestError;



class Sms extends Component{

    public $url = 'https://api.sms-activate.org/stubs/handler_api.php';

    public $apiKey ="164feAeA2A0741d494fcA793f3181Aff";

    /**
     * 获取账户余额
     * @return array|mixed|string
     * @throws RequestError
     */
    public function getBalance()
    {
            return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET');
    }

    /**
     * 使用现金返还帐户的余额请求
     * @return array|mixed|string
     * @throws RequestError
     */
    public function getBalanceAndCashBack()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET');
    }

    /**
     * 按服务请求顶级国家/地区
     * @param string $service
     * @param false $freePrice
     * @return array|mixed|string
     * @throws RequestError
     */
    public function getTopCountriesByService($service = '', $freePrice = false)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, '$freePrice' => $freePrice);
        return $this->request($requestParam, 'POST', true);
    }

    /**
     * 查询可供使用号码数量
     * @param null $country
     * @param null $operator
     * @return array
     * @throws RequestError
     */
    public function getNumbersStatus($country = null, $operator = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['service'] = $operator;
        }
        $response = array();
        $changeKeys = $this->request($requestParam, 'GET', true);
        foreach ($changeKeys as $services => $count) {
            $services = trim($services, "_01");
            $response[$services] = $count;
        }
        unset($changeKeys);
        return $response;
    }

    public function getNumber($service, $country = null, $forward = 0, $operator = null, $ref = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'forward' => $forward);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['operator'] = $operator;
        }
        if ($ref) {
            $requestParam['ref'] = $ref;
        }
        return $this->request($requestParam, 'POST', null, 1);
    }

    public function getMultiServiceNumber($services, $forward = 0, $country = null, $operator = null, $ref = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'multiService' => $services, 'forward' => $forward);
        if ($country) {
            $requestParam['country'] = $country;
        }
        if ($operator && ($country == 0 || $country == 1 || $country == 2)) {
            $requestParam['operator'] = $operator;
        }
        if ($ref) {
            $requestParam['ref'] = $ref;
        }
        return $this->request($requestParam, 'POST', true, 1);
    }

    public function setStatus($id, $status, $forward = 0)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'status' => $status);

        if ($forward) {
            $requestParam['forward'] = $forward;
        }

        return $this->request($requestParam, 'POST', null, 3);
    }

    public function getStatus($id)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id), 'GET', false, 2);
    }

    public function getCountries()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET', true);
    }

    public function getAdditionalService($service, $activationId)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'id' => $activationId), 'GET', false, 1);
    }

    public function getFullSms($id)
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id), 'GET');
    }

    public function getPrices($country = null, $service = null)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);
        if ($country !== null) {
            $requestParam['country'] = $country;
        }
        if ($service) {
            $requestParam['service'] = $service;
        }
        return $this->request($requestParam, 'GET', true);
    }

    public function getRentServicesAndCountries($time = 4, $operator = "any")
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'rent_time' => $time, 'operator' => $operator);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentNumber($service, $time = 4, $country = 0, $operator = "any", $url = '')
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'service' => $service, 'rent_time' => $time, 'operator' => $operator, 'country' => $country, 'url' => $url);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentStatus($id)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function setRentStatus($id, $status)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'status' => $status);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getRentList()
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function continueRentNumber($id, $time = 4)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'rent_time' => $time);
        return $this->requestRent($requestParam, 'POST', true);
    }

    public function getContinueRentPriceNumber($id, $time)
    {
        $requestParam = array('api_key' => $this->apiKey, 'action' => __FUNCTION__, 'id' => $id, 'rent_time' => $time);
        return $this->requestRent($requestParam, 'POST', false);
    }

    /**
     * @param $data
     * @param $method
     * @param null $parseAsJSON
     * @param null $getNumber
     * @return array|mixed|string
     * @throws RequestError
     */
    private function request($data, $method, $parseAsJSON = null, $getNumber = null)
    {
        $method = strtoupper($method);
        if (!in_array($method, array('GET', 'POST'))) {
            throw new InvalidArgumentException('Method can only be GET or POST');
        }
        $serializedData = http_build_query($data);
        if ($method === 'GET') {
            $result = file_get_contents("$this->url?$serializedData");
        } else {
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => $serializedData
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);
        }
        $responseError = new ErrorCodes($result);
        $check = $responseError->checkExist($result);
        try {
            if ($check) {
                throw new RequestError($result);
            }
        } catch (Exception $e) {
            return $e->getResponseCode();
        }
        if ($parseAsJSON) {
            return json_decode($result, true);
        }
        $parsedResponse = explode(':', $result);
        if ($getNumber == 1) {
            return array('id' => $parsedResponse[1], 'number' => $parsedResponse[2]);
        }
        if ($getNumber == 2) {
            return array('status' => $parsedResponse[0], 'code' => $parsedResponse[1]);
        }
        if ($getNumber == 3) {
            return array('status' => $parsedResponse[0]);
        }
        return $parsedResponse[1];
    }

    /**
     * @param $data
     * @param $method
     * @param null $parseAsJSON
     * @param null $getNumber
     * @return false|mixed|string
     */
    private function requestRent($data, $method, $parseAsJSON = null, $getNumber = null)
    {
        $method = strtoupper($method);

        if (!in_array($method, array('GET', 'POST'))) {
            throw new InvalidArgumentException('Method can only be GET or POST');
        }
        $serializedData = http_build_query($data);

        if ($method === 'GET') {
            $request_url = "$this->url?$serializedData";
            $result = file_get_contents($request_url);
        } else {
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => $serializedData
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);
        }

        if ($parseAsJSON) {
            $result = json_decode($result, true);
//            $responsError = new ErrorCodes($result["message"]);
//            $check = $responsError->checkExist($result["message"]);  // раскоментить если необходимо включить исключения для Аренды
//            if ($check) {
//                throw new RequestError($result["message"]);
//            }
            return $result;
        }
        return $result;
    }
}