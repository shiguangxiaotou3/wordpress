<?php
namespace crud\modules\wechat\models;;

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
     * @return bool
     */
    public function checkSignature(){
        if($this->tmpSignature === $this->signature){
            $data = $_GET;
            $data['TmpSignature']=$this->tmpSignature;
            wp_mail('757402123@qq.com','开发者服务器验证',print_r($data,true));
            return true;
        }else{
            return  false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(){
        return [
            "echostr" => "返回字符串",
            "signature" => "验证密钥",
            "timestamp" => "时间戳",
            "nonce" => "随机数",
            "token" => "Token",
        ];
    }

    /**
     * @return string $tmpSignature
     */
    public function getTmpSignature(){
        if(!isset($this->_tmpSignature)){
            $arr = [$this->token,$this->timestamp,$this->nonce];
            sort($arr);
            return sha1(implode("",$arr));
        }else{
            return $this->_tmpSignature;
        }
    }
}