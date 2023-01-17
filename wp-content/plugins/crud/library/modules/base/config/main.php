<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'base' => [
            'class' => 'crud\modules\base\Base',
        ],
    ],
    'components' => [
        "crawlers" => [
            'class' => "crud\modules\base\components\Crawlers",
            "ignore" => eval(get_option("crud_group_crawlers_ignore", 'return ["127.*","192.168.*"];')),
            "blacklist" => eval(get_option("crud_group_crawlers_blacklist", 'return [];')),
        ],
        "dns" => [
            'class' => "crud\modules\base\components\Dns",
            "accessKeyId" => get_option("crud_group_dns_accessKeyId", ""),
            "accessKeySecret" => get_option("crud_group_dns_accessSecret", ""),
        ],
        "aliyuncsOss" => [
            'class' => "crud\modules\base\components\AliyuncsOss",
             "accessKeyId"=>get_option("crud_group_aliyuncsOss_accessKeyId"),
            "accessKeySecret"=>get_option("crud_group_aliyuncsOss_accessKeySecret"),
            "endpoint"=>get_option("crud_group_aliyuncsOss_endpoint"),
            "isCName"=>get_option("crud_group_aliyuncsOss_isCName"),
            "securityToken"=>get_option("crud_group_aliyuncsOss_securityToken"),
            "requestProxy"=>get_option("crud_group_aliyuncsOss_requestProxy"),
        ],
    ],
    'params' => $params,
];


