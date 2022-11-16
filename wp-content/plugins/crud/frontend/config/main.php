<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);
return [
    'id' => 'frontend',
    'name' => '前台',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => "index",
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'components' => [
        // 不在需要layout,视图布局文件由wordpress决定
        'controller'=>[
            'class'=>" yii\web\Controller",
            'layout'=>false,
        ],
        "assetManager"=>[
            'class' => 'yii\web\AssetManager',
            "basePath" => '@frontend/web/assets',
            "baseUrl" => '/wp-content/plugins/crud/frontend/web/assets',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        "cache" => [
            'class' => "yii\caching\FileCache",
            "cachePath" => "@runtime/cache"
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        "urlManager" => [
//            "routeParam"=>"page"
        ],

//        'errorHandler' => [
//            'errorAction' => 'index/error',
//        ],
    ],
    'params' => $params,
];


