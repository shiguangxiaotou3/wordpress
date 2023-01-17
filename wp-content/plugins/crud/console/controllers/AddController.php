<?php

namespace console\controllers;

use Yii;
use crud\Base;
use crud\models\Rely;
use yii\console\Controller;
use crud\modules\wp\assets\WpAsset;
use crud\modules\ads\components\Ads;
use crud\modules\translate\components\GoogleTranslate;
use crud\modules\translate\components\MicrosoftTranslate;
use Shiguangxiaotou\Alipay\Request\AlipayTradePrecreateRequest;
use Exception;
use yii\helpers\Console;


/**
 * 测试应用
 */
class AddController extends Controller
{

    /**
     * 测试
     */
    public function actionIndex(){
       print_r(get_option('rewrite_rules'));
    }

    /**
     * 删除.DS_Store文件
     */
    public function actionDeleteDsStore(){
        $dir = dirname(__DIR__,5);
        deleteDsStore($dir,[".DS_Store"]);
    }

    /**
     * @return array|string[]
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            'C' => 'comment',
            'f' => 'fields',
            'p' => 'migrationPath',
            't' => 'migrationTable',
            'F' => 'templateFile',
            'P' => 'useTablePrefix',
            'c' => 'compact',
        ]);
    }

    /**
     * 批量生成模型
     */
    public function actionGii(){
        $ignore =["migration","wp_WechatReplay_keywords"];
        $sql = 'SHOW TABLES';
        $tables = Yii::$app->db->createCommand($sql)->queryAll();
        $cli =[];
        $tables = array_column($tables,"Tables_in_wp");
        foreach ($tables as $table){
            if(!in_array($table,$ignore)){
                $modelClass =toScoreUnder($table);
                $cli[]="php command  gii/model --ns=library\\\\models\\\\wp --modelClass=".
                    $modelClass." --tableName=".$table.
                    " --enableI18N=1 --messageCategory=wp  --useTablePrefix=1";
            }
        }
        file_put_contents(ABSPATH."gii.sh","#!/bin/bash\n".join("\n",$cli));
    }

    public function actionT(){
        $file =Yii::getAlias("@library/messages/wp/zh-CN/wp.php");
        $str = file_get_contents( $file);
        preg_match_all("/\'[^\']*\'/",$str,$data);
        $keys =array_unique($data[0]);
        $result=[];
        foreach ($keys as $key){
            $result[]= $key." =>''";
        }
        $str ="<?php\nreturn [\n".join(",\n",$result)."\n];";

        file_put_contents($file,"<?php\nreturn [\n".join(",\n",$result)."\n];");

    }

    /**
     * http测试
     */
    public function actionHttp(){
        $data =  Base::GET("https://www.baidu.com",[]);
        var_dump($data);
    }

    /**
     * 计算composer 依赖关系图
     */
    public function actionComposer(){
        $model = new Rely();
        $model->vendorDir = Yii::getAlias('@vendor');
//        $model->env = false;
        $model->baseComposerJson = ABSPATH."composer.json";
        $model->baseComposerLock = ABSPATH."composer.lock";
        file_put_contents('./test/index.html',$model->renderHtml());
    }

    /**
     * 微信公众号测试
     */
    public function actionMenu(){
        $wechat = Yii::$app->wechat;
        $menus = [
            "is_menu_open" => 1,
            "selfmenu_info" => [
                "button" => [
                    [
                        "type" => "click",
                        "name" => "今日歌曲",
                        "key" => "V1001_TODAY_MUSIC"
                    ],
                    [
                        "name" => "菜单",
                        "sub_button" => [
                            "list" => [
                                [
                                    "type" => "view",
                                    "name" => "搜索",
                                    "url" => "http://www.soso.com/"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "视频",
                                    "url" => "http://v.qq.com/"
                                ],
                                [
                                    "type" => "click",
                                    "name" => "赞一下我们",
                                    "key" => "V1001_GOOD"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $menu2 =
            [
                "button" => [
                    [
                        "type" => "click",
                        "name" => "今日歌曲",
                        "key" => "V1001_TODAY_MUSIC"
                    ],
                    [
                        "name" => "菜单",
                        "sub_button" => [
                            [
                                "type" => "view",
                                "name" => "搜索",
                                "url" => "http://www.soso.com/"
                            ],
//                            [
//                                "type" => "miniprogram",
//                                "name" => "wxa",
//                                "url" => "http://mp.weixin.qq.com",
//                                "appid" => "wx286b93c14bbf93aa",
//                                "pagepath" => "pages/lunar/index"
//                            ],
                            [
                                "type" => "click",
                                "name" => "赞一下我们",
                                "key" => "V1001_GOOD"
                            ]
                        ]
                    ]
                ],
//                "matchrule" => [
//                    "tag_id" => "2",
//                    "sex" => "1",
//                    "country" => "中国",
//                    "province" => "广东",
//                    "city" => "广州",
//                    "client_platform_type" => "2",
//                    "language" => "zh_CN"
//                ]
        ];
        $add = [
            "button" => [
                [
                    "type" => "click",
                    "name" => "今日歌曲",
                    "key" => "V1001_TODAY_MUSIC"
                ],
                [
                    "name" => "菜单",
                    "sub_button" => [
                        [
                            "type" => "view",
                            "name" => "搜索",
                            "url" => "http://www.soso.com/"
                        ],
//                        [
//                            "type" => "miniprogram",
//                            "name" => "wxa",
//                            "url" => "http://mp.weixin.qq.com",
//                            "appid" => "wx286b93c14bbf93aa",
//                            "pagepath" => "pages/lunar/index"
//                        ],
                        [
                            "type" => "click",
                            "name" => "赞一下我们",
                            "key" => "V1001_GOOD"
                        ]]
                ]]
        ];
        var_dump($wechat->createMenu( $menu2  ));
    }

    /**
     * 生成唯一的id
     * @throws \yii\db\Exception
     */
    public  function actionUuid(){
        echo Yii::$app->db->createCommand("select uuid() as uuid")->queryOne()['uuid'];
    }

    public function actionMicrosoft(){
        /** @var MicrosoftTranslate $microsoft */
        $microsoft = Yii::$app->microsoft;
        $params= http_build_query([
            'api-version'=> '3.0',
            'from'=> "adas",
            'to'=>  ['asd','aasd'],
        ]);
        $data =[ 'I would really like to drive your car around the block a few times!'=>'','hello word'=>''];
        logObject($microsoft->translate($data));
    }

    /**
     *
     */
    public function actionFile(){
        $arr =  [
            'index',
            'test',
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => false
            ]
        ];
        foreach ($arr as $item){
            if (is_array($item)){
                echo key($item)."\n";
            }
        }
    }

    /**
     * 阿里支付sdk加命名空间
     */
    public function actionAlipay(){
        $path = ABSPATH . "test/src/request";
        if (is_dir($path)) {
            //打开
            if ($dh = @opendir($path)) {
                //读取
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        if(is_file($path.'/'.$file)){
                            $str = file_get_contents($path.'/'.$file);
                            $str = str_replace("<?php\n","<?php\n"."namespace Shiguangxiaotou\\Alipay\\Request;\n",$str);
                            file_put_contents($path.'/'.$file,$str);
                        }

                    }
                }
                //关闭
                closedir($dh);
            }
        }
    }

    /**
     * google 翻译
     */
    public function actionGoogleTranslate(){
        /** @var GoogleTranslate  $api */
        $api = Yii::$app->google;
        $DATA =$api->languages();
        print_r($DATA);
    }

    /**
     * 阿里支付测试
     */
    public function actionPal(){
        $request = new AlipayTradePrecreateRequest ();
//        $pal = Yii::$app->alibaba;
//        $pal->test();
    }

    /**
     * @param string $basePath
     */
    public function actionUseSort($basePath =""){
        if (empty($basePath)) {
            $basePath = Yii::getAlias("@backend");
        }
        $handle = opendir($basePath);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                if (is_dir($basePath . "/" . $file)) {
                    echo "目录:" . $basePath . "/" . $file . "\n";
                    $this->actionUseSort($basePath . "/" . $file);
                }
                if (is_file($basePath . "/" . $file)) {
                    $fileName = explode('.', $file);
                    if ($fileName[1] == "php") {
                        echo "文件:" . $basePath . "/" . $file . "\n";
                        $text = file_get_contents($basePath . "/" . $file);
                        preg_match_all("/\nnamespace(.)*;/", $text, $namespace);
                        if (isset($namespace[0][0]) and !empty($namespace[0][0])) {
                            $namespace = str_replace(PHP_EOL, "", $namespace[0][0]);
                            preg_match_all("/\nuse(.)*;/", $text, $uses);
                            if (isset($uses[0]) and !empty($uses[0])) {
                                sort($uses[0]);
                                $tmp = [];
                                foreach ($uses[0] as $item) {
                                    $text = str_replace($item, "", $text);
                                    $item = str_replace(PHP_EOL, "", $item);
                                    $tmp[$item] = strlen($item);
                                }
                                asort($tmp);
                                $newStr = $namespace . PHP_EOL;
                                foreach ($tmp as $key => $value) {
                                    $newStr .= PHP_EOL . $key;
                                }
                                $newStr = str_replace($namespace, $newStr, $text);
                                file_put_contents($basePath . "/" . $file, $newStr);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * 阿里云oss上传测试
     * @param $basePath
     * @param string $dir
     * @param $oss
     */
    public function actionUploadAliyuncsOss($basePath='',$dir='',$oss=''){

        $this->getFiles('','',$arr);
        $oss = Yii::$app->aliyuncsOss;
        foreach ($arr as $key =>$value){
           $results= $oss->uploadFile("shiguangxiaotou", $key ,$value);
           if($results){
               echo "上传：".$key.PHP_EOL;
           }
        }
    }


    private function getFiles($basePath,$dir,&$arr){
        if(empty($basePath)){
            $basePath = Yii::getAlias("@uploads");
        }
        if(empty($dir)){
            $prefix =$basePath;
        }else{
            $prefix =$basePath."/".$dir;
        }
        $handle = opendir($prefix);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $s =   trim(  str_replace($basePath,"",$prefix."/".$file),'/');
                if(is_file($prefix."/".$file)){
                    $arr[$s] = $prefix."/".$file;
                }elseif(is_dir($prefix."/".$file) and  $file != "assets"){
                    $this->getFiles($basePath, $s,$arr);
                }
            }
        }
        closedir($handle);
    }

    /**
     *
     * 删除资源文件
     * @param string $basedir
     * @param string $dirName
     */
    public function actionDeleteAssets($basedir = '', $dirName = "")
    {
        if (empty($dirName)) {
            $dirName = Yii::getAlias('@uploads/assets');
        }
        if (empty($basedir)) {
            $basedir = Yii::getAlias('@uploads/assets');
        }
        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        $this->actionDeleteAssets($basedir, "$dirName/$item");
                    } else {
                        if (unlink("$dirName/$item")) {
                            $this->success("删除文件成功:$dirName/$item");
                        } else {
                            $this->error("删除文件失败:$dirName/$item");
                        }
                    }
                }
            }
            closedir($handle);
            if ($basedir != $dirName) {
                if (rmdir($dirName)) {
                    $this->success("删除目录成功:" . $dirName);
                } else {
                    $this->error("删除目录失败： $dirName/$item");
                }
            }
        }
    }


    /**
     * 控制台打印变量
     * @param $var
     * @param int $type
     */
    private function consoleEcho($var,$type =33){
        if(! empty($var)){
            if(is_string($var) or is_numeric($var)){
                $this->stdout(PHP_EOL. $var,$type);
            }
            if(is_object($var)){
                $arr = get_object_vars($var);
                $this->stdout(PHP_EOL. print_r($arr ,true),$type);
            }
            if(is_array($var)){
                $this->stdout(PHP_EOL. print_r($var,true),$type);
            }
        }else{
            $this->stdout(PHP_EOL. "空 啥也没有",$type);
        }

    }


    private function error($var){
        $this->consoleEcho($var,31);
    }
    private function success($var){
        $this->consoleEcho($var,32);

    }

    public function actionDeleteTest(){
        $fire ="/Library/WebServer/Documents/wp/wp-content/plugins/crud/library/a.txt";
        if (unlink( $fire)) {
            $this->success("删除文件成功: $fire");
        } else {
            $this->error("删除文件失败: $fire");
        }
        touch($fire);
        chmod($fire,0777);
//        file_put_contents($fire,'','','');
    }


    public function actionSearchStr($dirName=''){
        if(empty($dirName)){
//            $dirName = Yii::getAlias("@vendor/yiisoft");
            $dirName = Yii::getAlias("@crud");
        }
//        $str= 'Cannot declare class yii\db\ActiveRecord, because the name is already in use';
        $str ="/Cannot\ declare\ class\ (.)*\,\ because\ the\ name\ is\ already\ in\ use/";
//        $str ="/Cannot\ declare\ class/";
//        $str ="/because\ the\ name\ is\ already\ in\ use/";
        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if(is_file("$dirName/$item")){
                        $this->error("搜索文件:$dirName/$item");
                        $fileStr = file_get_contents("$dirName/$item");
                        preg_match_all( $str,$fileStr,$arr);
                        if(isset($arr[0]) and !empty($arr[0])){
                            $this->success($arr[0]);
                            $this->success("$dirName/$item");
                            die();
                        }
                    }else{
                        $this->error("$dirName/$item");
                        $this->actionSearchStr($dirName."/".$item);
                    }
                }
            }
        }
    }
}
// foreground color control codes
//前景颜色控制代码
//        const FG_BLACK = 30;
//        const FG_RED = 31;
//        const FG_GREEN = 32;
//        const FG_YELLOW = 33;
//        const FG_BLUE = 34;
//        const FG_PURPLE = 35;
//        const FG_CYAN = 36;
//        const FG_GREY = 37;
// background color control codes
//背景色控制代码
//        const BG_BLACK = 40;
//        const BG_RED = 41;
//        const BG_GREEN = 42;
//        const BG_YELLOW = 43;
//        const BG_BLUE = 44;
//        const BG_PURPLE = 45;
//        const BG_CYAN = 46;
//        const BG_GREY = 47;
// fonts style control codes
// 字体样式控制代码
//        const RESET = 0;
//        const NORMAL = 0;
//        const BOLD = 1;
//        const ITALIC = 3;
//        const UNDERLINE = 4;
//        const BLINK = 5;
//        const NEGATIVE = 7;
//        const CONCEALED = 8;
//        const CROSSED_OUT = 9;
//        const FRAMED = 51;
//        const ENCIRCLED = 52;
//        const OVERLINED = 53;