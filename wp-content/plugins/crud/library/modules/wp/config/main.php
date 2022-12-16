<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'wp' => [
            'class' => 'crud\modules\wp\Wp',
        ],
    ],
//    'components' => [
//
//    ],
    'params' => $params,
];


