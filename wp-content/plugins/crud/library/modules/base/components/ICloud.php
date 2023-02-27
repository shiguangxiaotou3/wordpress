<?php


namespace crud\modules\base\components;

use Qiniu\Auth;
use yii\base\Component;
use Qiniu\Storage\UploadManager;



class ICloud extends Component
{
    public $accessKey ="your accessKey";
    public $secretKey = "your secretKey";
    public $bucket = "your bucket name";

    public function init(){
        // 构建鉴权对象
        $auth = new Auth($this->accessKey, $this->secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($this->bucket);
        // 要上传文件的本地路径
        $filePath = './php-logo.png';
        // 上传到存储后保存的文件名
        $key = 'my-php-logo.png';
        // 如果指定了断点记录文件，那么下次会从指定的该文件尝试读取上次上传的进度，以实现断点续传
        $resumeFile = 'progress.log';
    }




}