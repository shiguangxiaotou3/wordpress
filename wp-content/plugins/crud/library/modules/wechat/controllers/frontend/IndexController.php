<?php
namespace crud\modules\wechat\controllers\frontend;

use yii\web\Controller;
use crud\modules\movie\Movie;
use crud\modules\movie\models\Movie as Model;
class IndexController extends Controller
{
    public $layout ='wechat';

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionAccessToken(){
        return $this->render('token');
    }
    public function actionTicket(){
        return $this->render('ticket');
    }
    public function actionJsSdk(){
        return $this->render('jssdk');
    }

    public function actionAction(){
        $title =$result ='';
        if(isset( $_GET['action'])){
            if($_GET['action'] =='cache'){
                $title="缓存清理";
                $result = \Yii::$app->cache->flush();
            }
            if($_GET['action'] =='seo'){
                $title="百度推送";
                $result = \json_decode( $this->baiduSeo());
//                $result =  $this->baiduSeo();
            }
        }

        return $this->render('action',[
            'title'=>$title,
            'result'=> $result
        ]);
    }
    public function baiduSeo(){
        $ids =  Model::find()->select('id')->column();
        $urls =[];
        $path = @getRequireUrl(1)."/movie/index/list";
        $i =0;
        foreach ($ids as $id){
            if($i<=200){
                $urls[] =$path."/".$id;
            }
            $i++;
        }
        $api = 'http://data.zz.baidu.com/urls?site=https://www.shiguangxiaotou.com&token=If9vjjXOhqDg46Es';
        $ch = \curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        return curl_exec($ch);
    }
}