<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'bootstrap'=>['crud'],
    'modules' => [
        'crud' => [
            'class' => 'crud\modules\crud\Crud',
        ],
    ],
    'components' => [
    ],
    'params' => $params,
];


