<?php

namespace console\controllers;

use Yii;
use crud\Base;
use Exception;
use crud\models\Rely;
use yii\helpers\Console;
use yii\console\Controller;
use crud\modules\wp\assets\WpAsset;
use crud\modules\ads\components\Ads;
use crud\modules\translate\components\GoogleTranslate;
use crud\modules\translate\components\MicrosoftTranslate;
use Shiguangxiaotou\Alipay\Request\AlipayTradePrecreateRequest;

/**
 * 测试应用
 */
class IndexController extends Controller
{

    /**
     * Crud插件目录权限设置
     */
    public function actionIndex(){

        $this->success("Wordpress plugins CRUD for MVC 初始化设置");
        $runtimes =[
            CRUD_DIR."/backend/runtime"=>0755,
            CRUD_DIR."/common/runtime"=>0755,
            CRUD_DIR."/console/runtime"=>0755,
            CRUD_DIR."/console/runtime"=>0755,
            rtrim(ABSPATH,"/").Yii::$app->assetManager->baseUrl=>0777,
            CRUD_DIR."/library/a.txt"=>0777,
            CRUD_DIR."/library/messages/console"=>0777,
        ];
        if (posix_getuid() == 0){
            foreach ($runtimes as $name=>$value){
                if(chmod ($name,$value)){
                    $this->success($name);
                }else{
                    $this->error($name);
                }
            }
            $this->error(''.PHP_EOL);
        } else {
            $this->error('此命令需要root权限'.PHP_EOL);
        }
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

    /**
     * 翻译I18N文件
     */
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
     * 计算composer 依赖关系图
     */
    public function actionComposer(){
        $model = new Rely();
        $model->vendorDir = Yii::getAlias('@vendor');
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

    /**
     * 微软翻译测试
     */
    public function actionMicrosoft(){
        set_time_limit(0);
        /** @var MicrosoftTranslate $microsoft */
        $microsoft = Yii::$app->microsoft;
        $data = json_decode( file_get_contents(ABSPATH."test/data.json"),true);
        $mic = include ABSPATH."test/data.php";
        $str ="## PHP常用拓展".PHP_EOL;
        foreach ($data as $row){
            $str .="#### ".$row["text"].PHP_EOL;
            $str .= "`https://www.php.net/manual/en/".$row["link"]."`".PHP_EOL;
            if(isset($row["describe"]) and  is_array($row["describe"])){
                foreach ($row["describe"] as $value){
                    if(isset($mic[$value])){
                        $value = $mic[$value];
                    }
                    $replace=[
                        "（"=>"(",
                        "）"=>")",
                        "“"=>"\"",
                        "。"=>".",
                        "，"=>",",
                        "："=>":",
                        "”"=>"\"",
                        "   "=>"",
                        PHP_EOL=>"",
                    ];
                    foreach ($replace as $key=>$item){
                        $value= str_replace($key,$item,$value);
                    }
                    $value= htmlToMarkdown($value);
                    $str .=$value.PHP_EOL;
                }
            }
            $str .=PHP_EOL;
        }
        file_put_contents(ABSPATH."test/data3.md",$str);
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
     * 调整php文件中的use排序
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

    /**
     * 获取目录下的所有文件
     * @param $basePath
     * @param $dir
     * @param $arr
     */
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
     * 删除资源包文件
     *
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

    /**
     * @param $var
     */
    private function error($var){
        $this->consoleEcho($var,31);
    }

    private function success($var){
        $this->consoleEcho($var,32);

    }

    /**
     * 删除测试文件
     */
    public function actionDeleteTest(){
        $fire ="/Library/WebServer/Documents/wp/wp-content/plugins/crud/library/a.txt";
        if (unlink( $fire)) {
            $this->success("删除文件成功: $fire");
        } else {
            $this->error("删除文件失败: $fire");
        }
        touch($fire);
        chmod($fire,0777);
    }

    /**
     * 搜索文件中的内容
     * @param string $dirName
     */
    public function actionSearchStr($dirName=''){
        if(empty($dirName)){
            $dirName ="/". trim(ABSPATH,"/");
        }
        $str ="/WP_REST_Server/";
        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if(in_array($item,[/*"admin-header.php",'admin-filters.php'*/]) ==false  ){
                        if(is_file("$dirName/$item")){
//                            $this->error("搜索文件:$dirName/$item");
                            $fileStr = file_get_contents("$dirName/$item");
                            preg_match_all( $str,$fileStr,$arr);
                            if(isset($arr[0]) and !empty($arr[0])){
//                                $this->success($arr[0]);
                                $this->success("$dirName/$item");
//                                die();
                            }
                        }else{
//                            $this->error("$dirName/$item");
                            $this->actionSearchStr($dirName."/".$item);
                        }
                    }

                }
            }
        }
    }

    public function actionSms(){
        $sms = Yii::$app->sms;
        dump($sms->getCountries());
    }

    /**
     * 定时删除可以文件
     * @param string $dirName
     */
    public function actionDelete($dirName=''){
        $url='https://www.shiguangxiaotou.com/wp-json/crud/api/wechat/mail';
        if(empty($dirName)){
            $dirName =  dirname( __DIR__,6);
        }

        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if(is_file("$dirName/$item")){
                        if($item =="wp-wimg.php"){
                            $this->post($url,["发现可以文件"=>"$dirName/$item",'删除'=>unlink("$dirName/$item")]);
                        }
                    }else{
                        $this-> actionDelete($dirName."/".$item);
                    }
                }
            }
        }
    }

    public function actionIp(){
        $str = Yii::getAlias("@library/ip.txt");
        $arr = unserialize(file_get_contents($str));
        foreach ($arr as $value){
            $crawlers = Yii::$app->crawlers;
            print_r($crawlers->getIpinfo($value));
        }
    }

    /**
     * @param $url
     * @param $data
     * @param array $header
     * @return false|string
     */
    private function post($url, $data, $header = [])
    {
        $data = http_build_query($data);
        if (empty($header)) {
            $headers = ['Content-type:application/x-www-form-urlencoded'];
        } else {
            $headers = $header;
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => $data
            ]
        ]);
        return file_get_contents($url, false, $context);
    }
}

/**
 * 解析html元素的属性
 * @param $html
 * @param bool $flags
 * @return array
 */
function htmlInfo($html,$flags=false){
    if(!empty($html) and is_string($html) and $html[0] =="<" and $html[strlen($html)-1]==">"){
        preg_match("/\<(?<Tag>[\w]+)(?<attribute>[^>]*)\>(?<content>(.)*)\<\/(?<endTag>[\w]+)\>/",$html,$result);
        $attribute_str = (isset($result['attribute']) and !empty($result['attribute'])) ? $result['attribute'] : "";
        $attribute =[];
        if (!empty($attribute_str)) {
            preg_match_all("/(\s[\w]+(\-[\w]+)*)/", $attribute_str, $attr);
            if (isset($attr[0]) and !empty($attr[0])) {
                foreach ($attr[0] as $key) {
                    $key = trim($key);
                    preg_match("/" . str_replace("-", "\\-", $key) .
                        "\=\"[^\"]*\"/", $attribute_str, $values);
                    if (isset($values[0]) and !empty($values[0])) {
                        $attribute[$key] = trim(str_replace("$key=", "", $values[0]), "\"");
                    } else {
                        $attribute[$key] = true;
                    }
                }
            }
        }
        $tag = (isset($result['Tag']) and
            isset($result['endTag']) and
            ($result['Tag']== $result['endTag'] ))? $result['Tag'] : "";
        $content =trim(isset( $result['content']) ? $result['content'] :"");
        return [
            'tag'=>$tag,
            'attribute'=> $attribute,
            'content'=> $flags ?  htmlInfo( $content,$flags) :$content,
        ];
    }else{
        return  $html;
    }
}

function htmlToMarkdown($datum){
    $datum= preg_replace_callback('/\<a[^\>]*\>[^\<]*\<\/a\>/',function($str){
        $aInfo =htmlInfo($str[0]);
        $href =isset( $aInfo['attribute']['href']) ?  $aInfo['attribute']['href']:"";
        return "[".$aInfo['content']."](".$href.")";
    },$datum);

    $datum =preg_replace_callback('/\<code[^\>]*\>[^\<]*\<\/code\>/',function($str){
        $aInfo =htmlInfo($str[0]);
        return "`".$aInfo['content']."`";
    },$datum);
    $datum =preg_replace_callback('/\<em[^\>]*\>[^\<]*\<\/em\>/',function($str){
        $aInfo =htmlInfo($str[0]);
        return "`".$aInfo['content']."`";
    },$datum);
    return preg_replace_callback('/\<span[^\>]*\>[^\<]*\<\/span\>/',function($str){
        $aInfo =htmlInfo($str[0]);
        return $aInfo['content'];
    },$datum);
}