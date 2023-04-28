<?php
namespace crud\modules\sms\components;

use Yii;
use yii\base\Component;
use crud\modules\sms\models\ErrorCodes;
use crud\modules\sms\models\RequestError;

class Sms extends Component{

    public $url;

    public $apiKey ;

    /**
     * @return array
     */
    public function getBalance()
    {
        return $this->request(array('api_key' => $this->apiKey, 'action' => __FUNCTION__), 'GET');
    }

    public function getCountry(){
        $cache = \Yii::$app->cache;
        if($cache->get("sms_country")){
            return $cache->get("sms_country");
        }else{
            if(file_exists(__DIR__."/data/country.json")){
                return json_decode(file_get_contents(__DIR__."/data/country.json"),true);
            }else{
                $data = json_decode(file_get_contents($this->url."?api_key=$this->apiKey&action=getCountries"),true);
                $cache->set('sms_country',$data);
                file_put_contents(__DIR__."/data/country.json",json_encode($data));
                return  $data;
            }
        }
    }

    public function getService(){
        $cache = Yii::$app->cache;
        if($server = $cache->get("sms_server")){
            return $server;
        }else{
            if(file_exists(__DIR__."/data/server.json")){
                $data =json_decode(file_get_contents(__DIR__."/data/server.json"),true);
                $cache->set("sms_server",$data);
                return $data;
            }
        }
    }

    /**
     * @param $data
     * @param $method
     * @param null $parseAsJSON
     * @param null $getNumber
     * @return array
     */
    private function request($data, $method, $parseAsJSON = null, $getNumber = null){
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
        $check = array_key_exists($result, $this->errorCodes);
        if($check){
            return [
                "code"=>0,
                "message"=>($this->errorCodes)[$result]
            ];
        }else{
            if($parseAsJSON){
                $data = json_decode($result);
            }
            return [
                "code"=>1,
                "message"=>"ok",
                "data"=>$data
            ];
        }

    }

    protected $errorCodes = array(
        'ACCESS_ACTIVATION' => 'Сервис успешно активирован',
        'ACCESS_CANCEL'     => 'активация отменена',
        'ACCESS_READY'      => 'Ожидание нового смс',
        'ACCESS_RETRY_GET'  => 'Готовность номера подтверждена',
        'ACCOUNT_INACTIVE'  => 'Свободных номеров нет',
        'ALREADY_FINISH'    => 'Аренда уже завершена',
        'ALREADY_CANCEL'    => 'Аренда уже отменена',
        'BAD_ACTION'        => 'Некорректное действие (параметр action)',
        'BAD_SERVICE'       => 'Некорректное наименование сервиса (параметр service)',
        'BAD_KEY'           => 'Неверный API ключ доступа',
        'BAD_STATUS'        => 'Попытка установить несуществующий статус',
        'BANNED'            => 'Аккаунт заблокирован',
        'CANT_CANCEL'       => 'Невозможно отменить аренду (прошло более 20 мин.)',
        'ERROR_SQL'         => 'Один из параметров имеет недопустимое значение',
        'NO_NUMBERS'        => 'Нет свободных номеров для приёма смс от текущего сервиса',
        'NO_BALANCE'        => 'Закончился баланс',
        'NO_YULA_MAIL'      => 'Необходимо иметь на счету более 500 рублей для покупки сервисов холдинга Mail.ru и Mamba',
        'NO_CONNECTION'     => 'Нет соединения с серверами sms-activate',
        'NO_ID_RENT'        => 'Не указан id аренды',
        'NO_ACTIVATION'     => 'Указанного id активации не существует',
        'STATUS_CANCEL'     => 'Активация/аренда отменена',
        'STATUS_FINISH'     => 'Аренда оплачена и завершена',
        'STATUS_WAIT_CODE'  => 'Ожидание первой смс',
        'STATUS_WAIT_RETRY' => 'ожидание уточнения кода',
        'SQL_ERROR'         => 'Один из параметров имеет недопустимое значение',
        'INVALID_PHONE'     => 'Номер арендован не вами (неправильный id аренды)',
        'INCORECT_STATUS'   => 'Отсутствует или неправильно указан статус',
        'WRONG_SERVICE'     => 'Сервис не поддерживает переадресацию',
        'WRONG_SECURITY'    => 'Ошибка при попытке передать ID активации без переадресации, или же завершенной/не активной активации'
    );
}