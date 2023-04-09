<?php


namespace crud\modules\pay\controllers;


use Yii;
use crud\modules\pay\models\Order;
use crud\controllers\ApiController;
class OrderController extends ApiController
{


    public function actionInit(){
        return $this->success('ok', [
            'page' => 1,
            // 分页大小
            "pageSize" => 10,
            "columns" => $this->findModel()->columns(),
            //获取字段配置url
            "actions" => [
                "init_url" => "pay/order/init",
                // 列表数据url
                "index_url" => "pay/order/index",
                // 新增数据url
                "add_url" => "pay/order/create",
                // 查看数据url
                "view_url" => "pay/order/view",
                // 更新数据url
                "update_url" => "pay/order/update",
                // 删除数据url
                "delete_url" => "pay/order/delete"
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
        if ($request->isAjax) {
            $query = Order::find();
            $page =$request->get('page', 1)-1;
            $pageSize = $request->get('pageSize', 10);
            $total = $query->count();
            $table = $query->offset($page*$pageSize)->limit($pageSize)->orderBy('created_at desc')->asArray()->all();
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
            if($model->load($request->post(),'Order') and $model->validate() and $model->save()){
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
        $request = Yii::$app->request;
        if ($request->isAjax) {
            if(!isset($id) or empty($id)){
                $id = $request->post('Order')['id'];
            }
            $model = Order::findOne($id);
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
        if ($request->isAjax) {
            $data = $request->post('Order');
            $model = Order::findOne($data['id']);
            if ($model->load($request->post(), 'Order') && $model->save()) {
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

        if(!isset($id) or empty($id)){
            $id = $request->post('Order')['id'];
        }
        $model = Order::findOne($id);
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
        $request = Yii::$app->request;
        $result =  Order::deleteAll(['IN','id',$request->post('ids')]);
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
        return new Order();
    }
}