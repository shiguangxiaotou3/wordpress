<?php
namespace crud\modules\market\controllers;


use Yii;
use yii\web\Controller;
use crud\components\Response;

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


    public function actionTest(){
        return  $this->render("test");
    }

    public function actionMy(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $orderTypeLise = $request->post('orderTypeLise');
            $severList = $request->post('severList');
            Yii::$app->response->format = Response::FORMAT_JSON;
            update_option('market_my_orderTypeLise',$orderTypeLise);
            update_option('market_my_severList',$severList);

            return json_encode(
                [
                    'code'=>1,
                    'message'=>'Success',
                    'time'=>time(),
                    'data'=>[
                        'orderTypeLise'=>$orderTypeLise,
                        'severList'=>$severList
                    ]
                ]
            );
        }
        return  $this->render("my");
    }

    public function actionPage(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $swiper = $request->post('swiper');
            Yii::$app->response->format = Response::FORMAT_JSON;
            update_option('market_index_swiper',$swiper);
            return json_encode(
                [
                    'code'=>1,
                    'message'=>'Success',
                    'time'=>time(),
                    'data'=>[
                        'swiper'=>$swiper,
                    ]
                ]
            );
        }
        return  $this->render("page");
    }


    /**
     * @return string
     */
    public function actionAddress(){
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/address',
            'title'=>'地址',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Address'
        ]);
    }

    /**
     * @return string
     */
    public function actionMoney(){
        return   $this->render("@crud/views/ajax",[
        'activeUrl'=>'market/index/money',
            'title'=>'余额管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Money'
        ]);
    }

    /**
     * @return string
     */
    public function actionCategorize(){
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/categorize',
            'title'=>'分类管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Categorize'
        ]);
    }

    /**
     * @return string
     */
    public function actionCommodity(){
        return   $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/commodity',
            'title'=>'商品管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Commodity'
        ]);
    }

    /**
     * @return string
     */
    public function actionCommodityPrice(){
        return   $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/commodity-price',
            'title'=>'商品价格管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'CommodityPrice'
        ]);
    }
    public function actionExpress(){
        return   $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/express',
            'title'=>'快递管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Express'
        ]);
    }
    public function actionStorehouse(){
        return   $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/storehouse',
            'title'=>'仓库管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'Storehouse'
        ]);
    }

    public function actionUser(){
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'market/index/user',
            'title'=>'用户管理',
            'url_prefix'=>'market',
            'links'=>json_encode($this->links()),
            'tableName'=>'User'
        ]);
    }

    private function links(){
        return [
            ['url' => 'market/index', 'label' => '商场'],
            ['url' => 'market/index/settings', 'label' => '基础设置'],
            ['url' => 'market/index/page', 'label' => '页面设置'],
            ['url' => 'market/index/my', 'label' => '个人中心'],
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