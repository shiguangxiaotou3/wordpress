<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'gii' => [
            'class' => 'crud\modules\gii\Module',
        ],
    ],
    'components' => [
    ],

    'params' => $params,
];


