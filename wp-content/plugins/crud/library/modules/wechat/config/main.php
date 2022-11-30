<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'components' => [
        "wechat"=>[
            "class"=>"crud\modules\wechat\components\SubscriptionService",
            "appId" =>get_option("crud_group_wechat_appId"),
            "appSecret" =>get_option("crud_group_wechat_appSecret"),
            "token" =>get_option("crud_group_wechat_token")
        ],
    ],
    'params' => $params,
];


