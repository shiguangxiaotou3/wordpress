<?php
namespace crud\modules\base\controllers;

use Yii;
use crud\models\Files;
use yii\web\Controller;
use yii\helpers\FileHelper;
use crud\modules\market\controllers\api\ApiController;
class IndexController extends Controller
{

    public $enableCsrfValidation=false;

    public $layout=false;

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionIpinfo()
    {
//        $request =Yii::$app->request;
//        $ips = $request->post("ips");
//        $ips = explode(",",$ips);
//        $crawlers = Yii::$app->crawlers;
//        $results =[];
//        foreach ($ips as $ip){
//            $re =$crawlers->getIpinfo($ip);
//            $results[] = [
//                "latLng" => explode(",", $re["loc"]),
//                "name" => Yii::t("city", $re["city"])
//            ];
//        }
//        return  $results;
        return $this->render("ipinfo");
    }

    /**
     * @return string
     */
    public function actionMail()
    {
        return $this->render("mail");
    }

    /**
     * @return string
     */
    public function actionDns()
    {
        return $this->render("dns");
    }

    /**
     * @return string
     */
    public function actionHighlight(){
        return $this->render("highlight");
    }

    /**
     * @return string
     */
    public function actionJvectormap(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $ips = $request->get("ips");
            $ips = explode(",",$ips);
            $crawlers = Yii::$app->crawlers;
            $results =[];
            foreach ($ips as $ip){
                $re =$crawlers->getIpinfo($ip);
                $results[] = [
                    "latLng" => explode(",", $re["loc"]),
                    "name" => Yii::t("city", $re["city"])
                ];
            }
           return  $this->success('ok',$results);
        }
        return $this->render("jvectormap");
    }

    /**
     * 爬虫检测
     * @return string
     */
    public function actionCrawlers(){
        return $this->render("crawlers");
    }

    /**
     * 阿里云Oss
     * @return string
     */
    public function actionOss(){
        return $this->render("oss");
    }

    /**
     * 阿里云Oss
     * @return string
     */
    public function actionEditor(){
        $request=  Yii::$app->request;
        if ($request->isAjax) {
            if ($request->isGet) {
                $tmp = '';
                $path = $request->get('path');
                if (substr($path, 0, 1) === '/') {
                    $tmp = "/" . trim($path, '/');
                    $path = dirname(__DIR__, 4) . $tmp;
                } elseif (substr($path, 0, 1) === '@') {
                    $tmp =  trim($path, '/');
                    $path = Yii::getAlias($path);

                }elseif($path =='/'){
                    $tmp = "/" ;
                    $path = dirname(__DIR__, 4) ;
                }

                $list =$this->getPathList($path);
                foreach ($list as $key=> $item) {
                    $list[$key]['name'] =  ($tmp !='/')? $tmp. '/' . $item['name'] : '/'.$item['name'];
                }
                $fileInfo = Files::fileInfo($path);
                if ($fileInfo) {
                    return $this->success('ok', [
                        'get'=>$_GET['path'],
//                        'path'=>$path,
                        'info' => $fileInfo,
                        'list' => $list
                    ]);
                } else {
                    return $this->error('error', [
                        'get'=>$_GET['path'],
//                        'path'=>$path
                    ]);
                }

            }

            if($request->isPost){

                $type =$request->post('type');
                $name = $request->post('name','');
                if($name =="/" or $name ==''){
                    return  $this->error('文件不能为空');
                }
                $path ='';
                if (substr( $name, 0, 1) === '/') {
                    $tmp = "/" . trim( $name, '/');
                    $path = dirname(__DIR__, 4) . $tmp;
                } elseif (substr( $name, 0, 1) === '@') {
                    $path = Yii::getAlias( $name);
                }
                if($type=='add'){
                    $arr =explode('/', $path);
                    if(!empty(end($arr))){
                        if(strpos(end($arr), '.') !== false){
                            if(!file_exists($path) and is_dir(dirname($path)) and is_writable(dirname($path))){
                                if(file_put_contents($path, '') and chmod($path, 0777)){
                                    return  $this->success('文件创建成功');
                                }else{
                                    return  $this->error('创建成功.但没有更改权限，意外错误');
                                }
                            }else{
                                return  $this->error('文件已存在,或没有操作权限');
                            }
                        }else{
                            if(is_dir($path) && is_writable($path)){
                                if( mkdir($path, 0777, true)){
                                    return  $this->success('目录创建成功');
                                }else{
                                    return  $this->error('意外错误');
                                }
                            }else{
                                return  $this->error('文件已存在,或没有操作权限');
                            }
                        }
                    }

                }elseif ($type =='delete'){
                    if(file_exists($path) and is_writable($path)){
                        if(unlink($path)){
                            return  $this->success('删除成功创建成功');
                        }else{
                            return  $this->error('意外错误');
                        }
                    }else{
                        return  $this->error('文件不存在,或没有操作权限');
                    }
                }elseif($type =='save'){
                    $text =stripslashes($request->post('text',''));
                    if(file_exists($path) and is_writable($path)){
                        if(file_put_contents($path, $text)){
                            return  $this->success('保存创建成功');
                        }else{
                            return  $this->error('意外错误');
                        }
                    }else{
                        return  $this->error('文件不存在,或没有操作权限');
                    }
                }
            }

        }
        return $this->render("editor");
    }

    public function actionMapping(){
        $request = Yii::$app->request;
        if($request->isAjax and $request->isPost){
            header('Content-Type: application/json');
            $files =$request->post('files');
            $res = update_option('base_validate_file',$files);
            if($res){
                flush_rewrite_rules();
                exit(@json_encode([
                    'code'=>'1',
                    'message'=>'ok',
                    'data'=>$request->post('files')
                ]));
            }else{
                exit(@json_encode([
                    'code'=>'0',
                    'message'=>'',
                ]));
            }
        }
        $file = get_option('base_validate_file',[]);
        return $this->render('mapping',['file'=>$file]);
    }
    /**
     * @param $message
     * @param $data
     * @param $header
     * @return false|string
     */
    public function success($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return @json_encode([
            'code' => 1,
            'message' => $message,
            'time' => time(),
            'data' => $data,
        ]);
    }

    public function error($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return @json_encode([
            'code' => 0,
            'message' => $message,
        ]);
    }
    public function getPathList($path){
        if(is_dir($path)){
            $handle = opendir($path);
            $result =[];
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    if(is_file($path."/".$file)){
                        $result[] = ['type' => 'file', 'name' => $file];
                    }elseif(is_dir($path."/".$file)){
                        $result[] = ['type' => 'dir', 'name' => $file];
                    }
                }
            }
            return $result;
        }else{
            return [];
        }

    }

    public function actionMovie(){

        $links = [
            ['label' => "设置", "url" => "base/index",],
            ['label' => "基础设置", "url" => "base/index/index",],
            ['label' => "访问记录", "url" => "base/index/ipinfo",],
            ['label' => "SMTP服务", "url" => "base/index/mail"],
            ['label' => "Dns解析", "url" => "base/index/dns",],
            ['label' => "代码高亮", "url" => "base/index/highlight",],
            ['label' => "jvectormap", "url" => "base/index/jvectormap",],
            ['label' => "爬虫检测","url" => "base/index/crawlers"],
            ['label' => "阿里云Oss", "url" => "base/index/oss",],
            ['label' => "编辑器", "url" => "base/index/editor",],
            ['label' => "文件验证", "url" => "base/index/mapping",],
            ['label' => "电影", "url" => "base/index/movie",],
        ];
        $js =<<<JS
$("#baidu-seo").click( function (){
   console.log('as') 
}
    
    // $.ajax({
    //     url: api,
    //     type: 'POST',
    //     contentType: 'text/plain',
    //     data: urls.join('\\n'),
    //     success: function(result) {
    //     }
    // })
    );
JS;

        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'base/index/movie',
            'title'=>'地址',
            'url_prefix'=>'base',
            'links'=>json_encode($links),
            'tableName'=>'Movie',
            'buttons'=>['<a class="page-title-action  thickbox" href="/wechat/index/action?action=seo&TB_iframe=true#TB_inline&width=350">百度seo</a>'],
            'js'=>$js
        ]);
    }
}