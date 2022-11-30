<?php


namespace crud\models\wechat;


use yii\base\Model;

/**
 * 开发者服务器验证模型
 * @property string $echostr;
 * @property string $signature;
 * @property integer $timestamp;
 * @property integer $nonce;
 * @property integer $token;
 * @property-read string $tmpSignature;
 * @package crud\common\model\weixin
 */
class ValidateServer extends Model{

    public $echostr;
    public $signature;
    public $timestamp;
    public $nonce;
    public $token;
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
        if($this->tmpSignature === $this->signature){
            return true;
        }else{
            return  false;
        }
    }


    /**
     * @return string $tmpSignature
     */
    public function getTmpSignature(){
        $tmpArr = array($this->token,$this->timestamp,$this->nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        return   $tmpStr;
    }
}