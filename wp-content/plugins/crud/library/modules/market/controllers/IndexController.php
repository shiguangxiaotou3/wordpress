<?php
namespace crud\modules\market\controllers;

use yii\web\Controller;
class IndexController extends Controller
{
    /**
     * 首页
     *
     * @return false|string
     */
    public function actionIndex(){

        return  $this->render("index");
    }

    /**
     * @return string
     */
    public function actionSettings(){
        return  $this->render("settings");
    }

    /**
     * @return string
     */
    public function actionAddress(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/address',
            'title'=>'地址',
            'links'=>json_encode($this->links()),
            'tableName'=>'Address'
        ]);
    }

    /**
     * @return string
     */
    public function actionMoney(){
        return  $this->render("crud",[
        'activeUrl'=>'market/index/money',
            'title'=>'余额管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'Money'
        ]);
    }

    /**
     * @return string
     */
    public function actionCategorize(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/categorize',
            'title'=>'分类管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'Categorize'
        ]);
    }

    /**
     * @return string
     */
    public function actionCommodity(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/commodity',
            'title'=>'商品管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'Commodity'
        ]);
    }

    /**
     * @return string
     */
    public function actionCommodityPrice(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/commodity-price',
            'title'=>'商品价格管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'CommodityPrice'
        ]);
    }
    public function actionExpress(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/express',
            'title'=>'快递管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'Express'
        ]);
    }
    public function actionStorehouse(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/storehouse',
            'title'=>'仓库管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'Storehouse'
        ]);
    }

    public function actionUser(){
        return  $this->render("crud",[
            'activeUrl'=>'market/index/user',
            'title'=>'用户管理',
            'links'=>json_encode($this->links()),
            'tableName'=>'User'
        ]);
    }

    public function actionTest(){
        return  $this->render("test");
    }

    private function links(){
        return [
            ['url' => 'market/index', 'label' => '商场'],
            ['url' => 'market/index/settings', 'label' => '基础设置'],
            ['url' => 'market/index/address', 'label' => '地址'],
            ['url' => 'market/index/money', 'label' => '余额管理'],
            ['url' => 'market/index/categorize', 'label' => '分类管理'],
            ['url' => 'market/index/commodity-price', 'label' => '商品价格管理'],
            ['url' => 'market/index/express', 'label' => '快递管理'],
            ['url' => 'market/index/storehouse', 'label' => '仓库管理'],
            ['url' => 'market/index/user', 'label' => '用户管理'],
        ];
    }
}