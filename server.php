<?php


class ValidateServer{

    public $echostr;
    public $signature;
    public $timestamp;
    public $nonce;
    public $token="asdasda";
    private $_tmpSignature;

    /**
     * {@inheritdoc}
     */
    public function rules(){
        return [
            [["echostr","timestamp","signature","nonce","token"],"required","message" => "{attribute}:不能为空!"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function checkSignature(){
        if($this->getTmpSignature() === $this->signature){
            return true;
        }else{
            return  false;
        }
    }


    /**
     * @return string $tmpSignature
     */
    public function getTmpSignature(){
        $arr = [$this->token,$this->timestamp,$this->nonce];
        sort($arr);
        return sha1(implode("",$arr));
    }
}

$model = new ValidateServer();
$model->echostr = $_GET["echostr"];
$model->signature = $_GET["signature"];
$model->timestamp = $_GET["timestamp"];
$model->nonce = $_GET["nonce"];
if( $model->checkSignature()){
    echo $model->echostr;
}