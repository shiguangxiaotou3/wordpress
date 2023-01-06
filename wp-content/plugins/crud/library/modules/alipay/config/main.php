<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'alipay' => [
            'class' => 'crud\modules\alipay\AliPay',
        ],
    ],
    'components' => [

    ],
    'params' => $params,
];


