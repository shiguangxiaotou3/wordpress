<?php


require __DIR__ . "/../../library/debug.php";
require __DIR__ . "/../../library/function.php";
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';

require __DIR__ . '/../config/bootstrap.php';
return  \yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php',
    \backend\web\App::loadModulesConfig()
);
