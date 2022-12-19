<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'editor' => [
            'class' => 'crud\modules\editor\Editor',
        ],
    ],
    'components' => [
    ],
    'params' => $params,
];


