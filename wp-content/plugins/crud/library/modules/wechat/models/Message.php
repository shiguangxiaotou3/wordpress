<?php


namespace  crud\modules\wechat\models;

use yii\base\Model;





class Message extends Model{

    const Type_Link ="link";
    const Type_Text ="text";
    const Type_ShortVideo= "shortvideo";//小视频
    const Type_Location="location"; //定位
    const Type_Video = "video";//视频
    const Type_Image ='image';//

    // 接收方微信号
    public $ToUserName;
    // 发送方微信号，若为普通用户，则是一个OpenID
    public $FromUserName;
    // 消息id，64位整型
    public $MsgId;
    // 消息创建时间
    public $CreateTime;
    // 消息类型
    public $MsgType;
    // 消息标题
    public $Title;
    // 文本消息内容
    public $Content;

    // 图片消息媒体id，可以调用获取临时素材接口拉取数据。
    public $MediaId;
    //  图片链接（由系统生成）
    public $PicUrl;
    // 语音格式，如amr，speex等
    public $format;
    // 语音识别结果，UTF8编码
    public $Recognition;
    // 视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据
    public $ThumbMediaId;
    // 地理位置纬度
    public $Location_X;
    // 地理位置经度
    public $Location_Y;
    // 地图缩放大小
    public $Scale;
    // 地理位置信息
    public $Label;
    // 消息描述
    public $Description;
    // Url	消息链接
    public $Url;

    // 消息的数据ID（消息如果来自文章时才有）
    public $MsgDataId;
    // 多图文时第几篇文章，从1开始（消息如果来自文章时才有）
    public $Idx;

}