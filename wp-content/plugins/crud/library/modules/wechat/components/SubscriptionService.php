<?php


namespace crud\modules\wechat\components;

use Yii;
use yii\base\Component;
use crud\modules\wechat\models\ValidateServer;
/**
 * 微信公众好组件
 * @property $appId appi
 * @property $appSecret
 * @public $token
 * @property-read $accessToken
 * @package crud\common\components\webxin
 */
class SubscriptionService extends Component{

    public $appId ;
    public $appSecret ;
    public $token ;
    public $_accessToken;

    /**
     * 验证开发者服务器
     */
    public function ValidateServer(){
        $request= Yii::$app->request;
        $model = new ValidateServer();
        $model->token=$this->token;
        $model->signature = $request->get("signature");
        $model->echostr = $request->get("echostr");
        $model->timestamp = $request->get("timestamp");
        $model->nonce  = $request->get("nonce");
        if($model->validate() and  $model->checkSignature()){
            return $model->echostr;
        }else{
            return $model->getErrors();
        }
    }

    /**
     * 获取access token
     * @return mixed
     */
    public function getAccessToken(){
        $cache = Yii::$app->cache;
        $access_token =$cache->get("wechat_access_token");
        if(empty($access_token)){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret;
            $data= json_decode( wp_remote_get( $url)['body'],true);
            $cache->set("wechat_access_token",$data["access_token"],$data["expires_in"]);
        }
        return $cache->get("wechat_access_token");

    }

}