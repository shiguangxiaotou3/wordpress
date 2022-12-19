<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'ads' => [
            'class' => 'crud\modules\ads\Ads',
        ],
    ],
    'components' => [
    ],
    'params' => $params,
];


