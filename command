#!/usr/bin/env php
<?php

$config = require "wp-content/plugins/crud/console/web/App.php";
use yii\console\Application;
use yii\base\InvalidConfigException;

try {
    $application = new Application($config);
    // 控制台汉化包装类
    $application->controllerMap['help'] = 'crud\controllers\HelpController';
    $exitCode = $application->run();
    exit($exitCode);
} catch (InvalidConfigException $e) {
    exit($e->getMessage());
}


//php command   gii/model --ns=crud\\models\\wp --tableName=wp_users --modelClass=WpUsers
//php command   gii/model --ns=crud\\models\\wp --tableName=wp_usermeta --modelClass=WpUserMeta

//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_address --modelClass=Address --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_money --modelClass=Money --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_categorize --modelClass=Categorize --enableI18N=1 --messageCategory=market




//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_categorize --modelClass=Categorize --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_commodity --modelClass=Commodity --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_commodity_price --modelClass=CommodityPrice --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_storehouse --modelClass=Storehouse --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_express --modelClass=Express --enableI18N=1 --messageCategory=market


