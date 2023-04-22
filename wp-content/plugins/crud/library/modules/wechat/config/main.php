<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'wechat' => [
            'class' => 'crud\modules\wechat\Wechat',
        ],
    ],
    'components' => [
        "subscription" => [
            'as message'=>'crud\modules\wechat\behaviors\SubscriptionServiceMessage',
            "class" => "crud\modules\wechat\components\SubscriptionService",
            "appId" => get_option("crud_group_wechat_appId"),
            "appSecret" => get_option("crud_group_wechat_appSecret"),
            "token" => get_option("crud_group_wechat_token"),
            "encodingAESKey" => get_option("crud_group_wechat_encodingAESKey"),
            "redirect_uri"=>get_option("crud_group_wechat_redirect_uri"),
            "domain" => get_option("crud_group_wechat_domain", 'https://api.weixin.qq.com')
        ],
    ],
    'params' => $params,
];


