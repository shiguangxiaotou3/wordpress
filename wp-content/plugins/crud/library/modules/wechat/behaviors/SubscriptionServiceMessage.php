<?php

namespace crud\modules\wechat\behaviors;

use Yii;
use yii\base\Behavior;
use crud\modules\wechat\models\WechatMessage;

class SubscriptionServiceMessage extends Behavior
{
    public $_ToUserName;
    public $_FromUserName;
    public $_msg=[];

    public $model_id;

    public $test ='qwe';
    /**
     * 微信数据
     *
     * @return void
     */
    public function wechatRequire(){
        $msg = Yii::$app->request->post();
        if(isset($msg["ToUserName"]) and isset($msg["FromUserName"])){
            $this->_ToUserName = $msg["ToUserName"];
            $this->_FromUserName = $msg["FromUserName"];
            $model = new WechatMessage();
            $model->msg_type = $msg['MsgType'];
            $model->from_username = $msg['FromUserName'];
            $model->to_user_name =$msg["ToUserName"];
            $model->msg_info = json_encode($msg);
            if(isset($msg['Event'])){
                $model->event_type = $msg['Event'];
            }
            if($model->save()){
                $this->model_id = $model->id;
            }else{
                wp_mail(['757402123@qq.com'],'保存失败',print_r($model->getErrors(),true));
            }
        }else{
            wp_mail(['757402123@qq.com'],'未知用户','');
        }
        return $msg;
    }

    public function wechatSendMessage(){

    }

    /**
     * 自动回复
     * @return null
     */
    public function autoMessage(){
         $this->wechatRequire();
         $this->sandEcho('asdas');
    }

    /**
     * 重复
     * @param $msg
     * @return string
     */
    public function sandEcho($msg)
    {
        $ToUserName = $msg['ToUserName'];
        $FromUserName = $msg['FromUserName'];
        $msg['ToUserName'] = $this->_FromUserName;
        $msg['FromUserName'] = $this->_ToUserName;
        $msg['CreateTime'] = time();
        return $this->sandXml($msg);

    }

    /**
     * 数组转xml字符串
     * @param $data
     * @return string
     */
    public function sandXml($data)
    {
        header("Content-Type:application/xml; charset=utf-8");
        $xml = "<xml>";
        foreach ($data as $key => $value) {
            if (is_numeric($value)) {
                $xml .= "<$key>$value</$key>";
            } else {
                $xml .= "<$key><![CDATA[$value]]></$key>";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 回复文本消息
     * @param $Content
     * @param string $MsgType
     * @return string
     */
    public function sandText($Content, $MsgType = "text")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "Content" => $Content,
        ]);
    }

    /**
     * 回复图片消息
     * @param $MediaId
     * @param string $MsgType
     * @return string
     */
    public function sendImage($MediaId, $MsgType = "image")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "Image" => ['MediaId' => $MediaId],
        ]);
    }

    /**
     * 回复语音消息
     * @param $MediaId
     * @param string $MsgType
     * @return string
     */
    public function sendVoice($MediaId, $MsgType = "voice")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "Voice" => ['MediaId' => $MediaId],
        ]);
    }

    /**
     * 回复视频消息
     * @param $MediaId
     * @param $Title
     * @param $Description
     * @param string $MsgType
     * @return string
     */
    public function sendVideo($MediaId, $Title, $Description, $MsgType = "video")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "Video" => [
                'MediaId' => $MediaId,
                'Title' => $Title,
                "Description" => $Description,
            ],
        ]);
    }

    /**
     * 回复音乐消息
     * @param $Title 音乐标题
     * @param $Description 音乐描述
     * @param $MusicUrl 音乐链接
     * @param $HQMusicUrl 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param $ThumbMediaId 缩略图的媒体id，通过素材管理中的接口上传多媒体文件，得到的id
     * @param string $MsgType
     * @return string
     */
    public function sendMusic($Title, $Description, $MusicUrl, $HQMusicUrl, $ThumbMediaId, $MsgType = "music")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "Music" => [
                'Title' => $Title,
                "Description" => $Description,
                'MusicUrl' => $MusicUrl,
                "HQMusicUrl" => $HQMusicUrl,
                'ThumbMediaId' => $ThumbMediaId,
            ],
        ]);
    }

    /**
     * 回复一条图文消息
     * @param $Title
     * @param $Description
     * @param $PicUrl
     * @param $Url
     * @param string $MsgType
     * @return string
     */
    public function sendNewsOne($Title, $Description, $PicUrl, $Url, $MsgType = "news")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "ArticleCount" => 1,
            'Articles' => [
                [
                    "Title" => $Title,
                    'Description' => $Description,
                    'PicUrl' => $PicUrl,
                    'Url' => $Url,
                ],
            ],
        ]);
    }

    /**
     * 回复多条图文消息
     * @param $Articles
     * @param string $MsgType
     * @return string
     */
    public function sendNews($Articles, $MsgType = "news")
    {
        return $this->sandXml([
            "ToUserName" => $this->_FromUserName,
            "FromUserName" => $this->_ToUserName,
            "CreateTime" => time(),
            "MsgType" => $MsgType,
            "ArticleCount" => count($Articles),
            'Articles' => $Articles
        ]);
    }
}