<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'modules' => [
        'market' => [
            'class' => 'crud\modules\market\Market',
        ],
    ],
    'components' => [
        "marketApi"=>[
            'class'=>"crud\modules\market\components\BaseComponent",
        ],
        "wechatApplet"=>[
            'class'=>"crud\modules\market\components\WechatApplet",
            'appId'=>get_option('crud_group_market_appid'),
            'appSecret'=>get_option('crud_group_market_appSecret'),
        ],
        "tencent"=>[
            'class'=>"crud\modules\market\components\Tencent",
        ]
    ],
    'params' => $params,
];


