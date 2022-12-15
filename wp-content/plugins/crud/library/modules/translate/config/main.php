<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'translate' => [
            'class' => 'crud\modules\translate\Translate',
        ],
    ],
    'components' => [
        'translate' => [
            'class' => 'crud\modules\translate\components\TranslateComponent',
            'type'=>get_option("crud_group_google_type"),
        ],
        "google" => [
            'class' => 'crud\modules\translate\components\GoogleTranslate',
            'translateKey' =>get_option("crud_group_google_key"),
            'shortcut' =>get_option("crud_group_google_shortcut"),
        ],
        "youdao"=>[
            "class"=>'crud\modules\translate\components\YoudaoTranslate',
            "appId"=>get_option("crud_group_youdao_appId"),
            "appSecret" =>get_option("crud_group_youdao_appSecret"),
            'shortcut' =>get_option("crud_group_youdao_shortcut"),
        ],
        "baidu"=>[
            "class"=>'crud\modules\translate\components\BaiduTranslate',
            "appId"=>get_option("crud_group_baidu_appId"),
            "appSecret" =>get_option("crud_group_baidu_appSecret"),
            'shortcut' =>get_option("crud_group_baidu_shortcut"),
        ],
        "microsoft"=>[
            "class"=>'crud\modules\translate\components\MicrosoftTranslate',
            "key"=>get_option("crud_group_microsoft_key"),
            "location" =>get_option("crud_group_microsoft_location"),
            'shortcut' =>get_option("crud_group_microsoft_shortcut"),
        ]
    ],
    'params' => $params,
];


