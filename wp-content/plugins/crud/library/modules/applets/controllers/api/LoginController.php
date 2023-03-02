<?php


namespace crud\modules\applets\controllers\api;

use Yii;
use yii\web\Controller;




class LoginController extends Controller
{

    public $layout = false;

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex()
    {

    }

    /**
     * 接收微信消息
     */
    public function actionCreate()
    {
        $request = Yii::$app->request ;
        $cache = Yii::$app->cache;
        $data = $cache->get('server_login');
        $tmp = is_array($data) ?   $data :  [];
        if($request->isPost){
            $name = $request->post('name');
            $ip = $request->post('ip');
            if(!empty($name) and !empty($ip)){
                $tmp[] =[
                    'name'=>$name,
                    'ip'=>$ip,
                    'time'=>date('Y-m-d H:i:s')
                ];
                $cache->set('server_login',$tmp);
                return 'success';
            }
        }
    }

}