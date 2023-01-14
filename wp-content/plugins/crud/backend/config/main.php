<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id' => 'backend',
    'name' => '时光小偷的博客',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => "index",
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'components' => [
        // 不在需要layout,视图布局文件由wordpress决定
        'controller'=>[
            'class'=>" yii\web\Controller",
            'layout'=>false,
        ],
        "assetManager"=>[
            // 定义资源包发布目录， you project/wp-content/uploads/assets
            'class' => 'yii\web\AssetManager',
            "basePath" => '@uploads/assets',
            "baseUrl" => '/wp-content/uploads/assets',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'text/xml' => 'crud\components\XmlRequestParser',
                'application/xml' => 'crud\components\XmlRequestParser',
            ],
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
            "routeParam"=>"page",
            "rules" => [
                "<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>"=>"<controller>/<action>",
                "<controller:[\w-]+>/<action:[\w-]+>"=>"<controller>/<action>",
            ]
        ],

        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
    ],
    'params' => $params,
];


