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
        ],
        "google" => [
            'class' => 'crud\modules\translate\components\GoogleTranslate',
            'translateKey' =>get_option("crud_group_translate_key"),
        ],
        "youdao"=>[
            "class"=>'crud\modules\translate\components\YoudaoTranslate',
            "appId"=>"27bb082802437b82",
            "appSecret" =>"9gPGRT9Rfa7Yrtdpd6YJOjI3T8G0hwxD",
        ],
        "baidu"=>[
            "class"=>'crud\modules\translate\components\BaiduTranslate',
            "appId"=>"20221117001457698",
            "appSecret" =>"ZGY6lha11ueLEpyHkuNO",
        ]
    ],
    'params' => $params,
];


