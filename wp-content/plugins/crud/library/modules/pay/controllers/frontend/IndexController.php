<?php

namespace crud\modules\pay\controllers\frontend;

use yii\web\Controller;
class IndexController extends Controller
{

    /**
     * @return string
     */
    public function actionPay(){
        return $this->render("pay");
    }

}