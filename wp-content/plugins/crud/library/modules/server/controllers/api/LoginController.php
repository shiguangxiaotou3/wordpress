<?php
namespace crud\modules\server\controllers\api;

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

    public function actionCreate()
    {
        $request = Yii::$app->request ;
        $cache = Yii::$app->cache;
        $data = $cache->get('server_login');
        $tmp = is_array($data) ?   $data :  [];
        if($request->isPost){
            $name = $request->post('name');
            $server = $request->post('server');
            $ip = $request->post('ip');
            if(!empty($name) and !empty($ip)){
                $res =[
                    'server'=>$server,
                    'name'=>$name,
                    'ip'=>$ip,
                    'time'=>date('Y-m-d H:i:s')
                ];
                $tmp[] =$res;
                $this->sendMail($res);
                $cache->set('server_login',$tmp);
                return 'success';
            }
        }
    }

    public function sendMail($res){
        try{
            $config = eval(get_option('crud_group_server_gitignore','return [];'));
            if(isset($config) and !empty($config)){
                if(isset($config[$res['server']]) ){
                    $mail = isset($config[$res['server']]['mail']) ? $config[$res['server']]['mail'] : [];
                    $ips = isset($config[$res['server']]['ips']) ? $config[$res['server']]['ips'] : [];
                    if(!empty($mail) and !empty($ips) and !in_array($res['ip'],$ips)){
                        $ipinfo =Yii::$app->crawlers->getIpinfo($res['ip']);
                        $message =[
                            '服务器名称:'.$res['server'],
                            '登录用户名:'.$res['name'],
                            'ip 地址:'.$res['ip'],
                            '登录时间:'.$res['time'],
                            '登录地址:'.Yii::t('city',$ipinfo['country'])." ".
                            Yii::t('city',$ipinfo['region'])." ".
                            Yii::t('city',$ipinfo['city'])." ". $ipinfo['loc']
                        ];
                        logObject($message);
                        wp_mail($mail,'服务器异常登录',join("\n",$message));
                    }
                }
            }
        }catch (\Exception $exception){
            return ;
        }

    }

}