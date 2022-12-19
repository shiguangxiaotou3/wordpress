<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'seo' => [
            'class' => 'crud\modules\seo\Seo',
        ],
    ],
    'components' => [
        'seo'=>[
            'class'=>"crud\modules\seo\components\SeoComponent"
        ],
        'seo_baidu'=>[
            'class'=>"crud\modules\seo\components\BaiduSeo",
            'token' => get_option("crud_group_seo_baidu_token", ""),
            'uri' => get_option("crud_group_seo_baidu_uri", "")
        ]
    ],
    'params' => $params,
];


