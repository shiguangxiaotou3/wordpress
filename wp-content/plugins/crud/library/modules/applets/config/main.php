<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'applets' => [
            'class' => 'crud\modules\applets\Applets',
        ],
    ],
    'components' => [
        'appletsServer'=>[
            'class'=> 'crud\modules\applets\components\AppletsServer',
            "appId" => get_option("crud_group_applets_appId"),
            "appSecret" => get_option("crud_group_applets_appSecret"),
        ]

    ],
    'params' => $params,
];


