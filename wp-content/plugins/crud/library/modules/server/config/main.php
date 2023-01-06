<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'server' => [
            'class' => 'crud\modules\server\Server',
        ],
    ],
    'components' => [
    ],
    'params' => $params,
];


