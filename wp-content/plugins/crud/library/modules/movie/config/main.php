<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'movie' => [
            'class' => 'crud\modules\movie\Movie',
        ],
    ],
    'components' => [

    ],
    'params' => $params,
];


