<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'sms' => [
            'class' => 'crud\modules\sms\Sms',
        ],
    ],
    'components' => [
        "smsComponent" => [
            "class" => "crud\modules\sms\components\Sms",
            "url" => get_option("crud_group_sms_url"),
            "apiKey" => get_option("crud_group_sms_apiKey"),
        ],
    ],
    'params' => $params,
];


