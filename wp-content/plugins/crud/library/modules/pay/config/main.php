<?php


$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'modules' => [
        'pay' => [
            'class' => 'crud\modules\pay\Pay',
        ],
    ],
    'components' => [
        "alipay" => [
            'class' => "crud\modules\pay\components\Alipay",
            "appId" => get_option("crud_group_alipay_appId"),
            "appName" => get_option("crud_group_alipay_appName"),
            "pid" => get_option("crud_group_alipay_pid"),
            "alipayUli" => get_option("crud_group_alipay_alipayUli"),
            "gateway" => get_option("crud_group_alipay_gateway"),
            "returnUrl" => get_option("crud_group_alipay_returnUrl"),
            "notifyUrl" => get_option("crud_group_alipay_notifyUrl"),
            "authorizationCallbackUil" => get_option("crud_group_alipay_authorizationCallbackUil"),
            "encryptType" => get_option("crud_group_alipay_encryptType"),
            "signType" => get_option("crud_group_alipay_signType"),
            "contentEncryptType" => get_option("crud_group_alipay_contentEncryptType"),
            "contentSecretKey" => get_option("crud_group_alipay_contentSecretKey"),

            "appPrivateKey" => get_option("crud_group_alipay_appPrivateKey"),
            "appPublicKey" => get_option("crud_group_alipay_appPublicKey"),
            "alipayPublicKey" => get_option("crud_group_alipay_alipayPublicKey"),
            "appPublicCert" => get_option("crud_group_alipay_appPublicCert"),
            "alipayPublicCert" => get_option("crud_group_alipay_alipayPublicCert"),
            "alipayRootCert" => get_option("crud_group_alipay_alipayRootCert"),
        ]
    ],
    'params' => $params,
];


