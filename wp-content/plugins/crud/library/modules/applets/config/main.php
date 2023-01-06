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
    ],
    'params' => $params,
];


