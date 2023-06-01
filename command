#!/usr/bin/env php

<?php
defined('YII_ENV') or define('YII_ENV', 'dev');
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


//"sudo npm pack vuedraggable@^2.24.3",
//      "sudo mkdir -p ./wp-content/plugins/crud/vendor/bower-asset/vuedraggable",
//      "sudo tar -xf vuedraggable-2.24.3.tgz -C ./wp-content/plugins/crud/vendor/bower-asset/vuedraggable --strip-components=1 --include=\"*/dist/*\"",
//      "sudo rm -R vuedraggable-2.24.3.tgz",

//"sudo npm  pack install vuedraggable@^2.24.3  --no-save --no-bin-links --prefix ./wp-content/plugins/crud/vendor/bower-asset",
//      "mkdir ./wp-content/plugins/crud/vendor/npm-asset/vuedraggable",
//  "sudo bower install vuedraggable#^2.24.3 --allow-root",
////      "sudo mkdir -p wp-content/plugins/crud/vendor/npm-asset",
//php command   gii/model --ns=crud\\models\\wp --tableName=wp_users --modelClass=WpUsers
//php command   gii/model --ns=crud\\models\\wp --tableName=wp_usermeta --modelClass=WpUserMeta

//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_address --modelClass=Address --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_money --modelClass=Money --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_categorize --modelClass=Categorize --enableI18N=1 --messageCategory=market

//php command   gii/model --ns=crud\\modules\\pay\\models --tableName=wp_pay_reflect --modelClass=PayReflect --enableI18N=1 --messageCategory=pay


//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_categorize --modelClass=Categorize --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_commodity --modelClass=Commodity --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_commodity_price --modelClass=CommodityPrice --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_storehouse --modelClass=Storehouse --enableI18N=1 --messageCategory=market
//php command   gii/model --ns=crud\\modules\\market\\models --tableName=wp_express --modelClass=Express --enableI18N=1 --messageCategory=market

//php command   gii/model --ns=crud\\modules\\movie\\models --tableName=wp_movie --modelClass=Movie --enableI18N=1 --messageCategory=app
//php command   gii/model --ns=crud\\modules\\wechat\\models --tableName=wp_wechat_message --modelClass=WechatMessage --enableI18N=1 --messageCategory=wechat
//php command   gii/model --ns=crud\\modules\\wechat\\models --tableName=wp_imessage --modelClass=iMessage --enableI18N=1 --messageCategory=app
