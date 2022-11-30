<?php

/**
 *
 *
 * @name TestController.php
 * @author 时光小偷
 * @package wordpress
 * @time  2022-9-27 2:51
 */

namespace console\controllers;
use crud\library\components\Ads;
use yii\console\Controller;
/**
 * 测试应用
 */
class TestController extends Controller
{

    /**
     * 测试
     */
    public function actionIndex(){
        /** @var Ads $ads */
        $ads = \Yii::$app->ads;
        print_r( $ads-> GetCustomerInfo($ads->customerId));
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
}