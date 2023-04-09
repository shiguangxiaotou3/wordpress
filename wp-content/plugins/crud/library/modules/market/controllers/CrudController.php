<?php


namespace crud\modules\market\controllers;

use Yii;
use crud\controllers\ApiController;

class CrudController extends ApiController
{
    public $modelClass;

    public $modelName;

    public function actionInit(){
        $url =toUnderScore($this->modelName,'-');
        return $this->success('ok', [
            'page' => 1,
            // 分页大小
            "pageSize" => 10,
            "columns" => $this->findModel()->columns(),
            //获取字段配置url
            "actions" => [
                "init_url" => "market/". $url."/init",
                // 列表数据url
                "index_url" => "market/". $url."/index",
                // 新增数据url
                "add_url" => "market/". $url."/create",
                // 查看数据url
                "view_url" => "market/". $url."/view",
                // 更新数据url
                "update_url" => "market/". $url."/update",
                // 删除数据url
                "delete_url" => "market/". $url."/delete",
                "deletes_url" => "market/". $url."/deletes"
            ]
        ]);
    }

    /**
     * 订单查询
     * @return false|string
     * @author ChatGPT
     * @date 2023-03-21
     */
    public function actionIndex(){
        $request =Yii::$app->request;
        $class =$this->modelClass;
        if ($request->isAjax) {
            $query = $class::find();
            $page =$request->get('page', 1)-1;
            $pageSize = $request->get('pageSize', 10);
            $total = $query->count();
            $orderBy='';
            if(isset($query->created_at)){
                $orderBy ='created_at desc';
            }

            $table = $query->offset($page*$pageSize)->limit($pageSize)->orderBy($orderBy)->asArray()->all();
            return  $this->success('ok', [
                'page' => $page,
                'pageSize' => $pageSize,
                'total' => $total,
                'table' => $table ,
            ]);

        }
    }

    /**
     * 创建一条新的订单记录
     *
     * @author: ChatGPT-4
     * @date: 2023-03-20 17;04
     * @return array
     */
    public function actionCreate(){
        $request =Yii::$app->request;
        if($request->isAjax){
            $model = $this->findModel();
            if($model->load($request->post(),$this->modelName) and $model->validate() and $model->save()){
                return $this->success('ok',['id'=>$model->id]);
            }else{
                return $this->error('error',$model->getErrors());
            }
        }
    }

    /**
     * 查看一条订单记录
     *
     * @param int $id 订单id
     * @return array
     * @author: ChatGPT-4
     * @date: 2023-03-20 17:30
     */
    public function actionView($id='')
    {
        $class =$this->modelClass;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            if(!isset($id) or empty($id)){
                $id = $request->post($this->modelName)['id'];
            }
            $model =  $class ::findOne($id);
            if ($model) {
                return $this->success('ok', $model);
            } else {
                return $this->error('订单不存在');
            }
        }
    }

    /**
     * 更新指定id的订单记录
     *
     * @param int $id 订单id
     * @return array
     *
     * @author: ChatGPT-4
     * @date: 2023-03-20 17:30
     */
    public function actionUpdate(){
        $request = Yii::$app->request;
        $class =$this->modelClass;
        if ($request->isAjax) {
            $data = $request->post($this->modelName);
            $model =  $class::findOne($data['id']);
            if ($model->load($request->post(), $this->modelName) && $model->save()) {
                return $this->success('ok', $model);
            } else {
                return $this->error('error', $model->getErrors());
            }
        }
    }

    /**
     * 删除指定的订单记录
     *
     * @param int $id 订单ID
     * @return array
     *
     * @throws Throwable
     * @throws yii\db\StaleObjectException
     * @author ChatGPT
     * @date 2023-03-21
     */
    public function actionDelete($id='')
    {
        $request = Yii::$app->request;
        $class =$this->modelClass;
        if(!isset($id) or empty($id)){
            $id = $request->post($this->modelName)['id'];
        }
        $model = $class ::findOne($id);
        if ($model and $model->delete()) {
            return $this->success('删除成功');
        } else {
            return $this->error('删除失败', $model->getErrors());
        }
    }

    /**
     * 删除指定的订单记录
     *
     * @param Yii $ids
     * @return array
     *
     * @throws Throwable
     * @throws yii\db\StaleObjectException
     * @author ChatGPT
     * @date 2023-03-21
     */
    public function actionDeletes($ids='')
    {
        $class =$this->modelClass;
        $request = Yii::$app->request;
        $result =  $class::deleteAll(['IN','id',$request->post('ids')]);
        if ($result ) {
            return $this->success('删除成功');
        } else {
            return $this->error('删除失败', $result->getErrors());
        }
    }

    /**
     * 模型
     * @author ChatGPT
     * @date 2023-03-21
     */
    protected function findModel(){
        $class =$this->modelClass;
        return new $class();
    }

}