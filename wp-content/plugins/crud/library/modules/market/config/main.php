<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'modules' => [
        'market' => [
            'class' => 'crud\modules\market\Market',
        ],
    ],
    'components' => [
        "marketBase"=>[
            'class'=>"crud\modules\market\components\BaseComponent"
        ]
    ],
    'params' => $params,
];


