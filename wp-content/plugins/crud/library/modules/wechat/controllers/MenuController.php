<?php

namespace crud\modules\wechat\controllers;


use crud\controllers\ApiController;
use Yii;
class MenuController extends ApiController
{

    /**
     * 查询菜单
     * @return false|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionGetMenu(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            return $this->json($subscription->getMenu());
        }
    }

    /**
     * 设置菜单
     * @return false|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionSetMenu(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            $menu = Yii::$app->request->post();
            $tmp=[];
            foreach ($menu['button'] as $item){
                $t = $item;
                if(isset($item['sub_button']) and isset($item['sub_button']['list'])){
                   if(empty($item['sub_button']['list'])){
                       unset($t['sub_button']);
                   }else{
                       $t['sub_button'] = $item['sub_button']['list'];
                   }
                }
                $tmp[] = $t;
            }
            $subscription->deleteMenu();
            if($subscription->setMenu(['button'=>$tmp])){
                return $this->success('成功');
            }

        }
        return $this->error( '失败');
    }

    /**
     * 删除菜单
     * @return false|string|void
     */
    public function actionDeleteMenu(){
        if(Yii::$app->request->isAjax){
            $subscription =Yii::$app->subscription;
            if( $subscription->deleteMenu()){
                return $this->success('成功');
            }
        }
        return $this->error( '失败');
    }
}