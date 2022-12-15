<?php

use crud\modules\wp\Wp;
use yii\helpers\ArrayHelper;
use crud\modules\wechat\Wechat;
use crud\modules\translate\Translate;


defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . "/../../library/debug.php";
require __DIR__ . "/../../library/function.php";
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';




require __DIR__ . '/../config/bootstrap.php';
$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php',
    Wechat::config(),
    Translate::config(),
    Wp::config()
);
return $config;