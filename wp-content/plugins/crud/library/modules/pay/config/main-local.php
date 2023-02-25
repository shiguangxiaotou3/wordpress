<?php
/**
 *
 * @package crud
 */

return [
    'components' => [
        'alibaba' => [
            'class' => 'crud\modules\pay\components\Alipay',
            // appID
            'appId' => get_option("crud_group_alibaba_appId", ''),
            // 应用名称
            'appName' => get_option("crud_group_alibaba_appName", ''),
            // 绑定的商家账号(PID)
            'pid' => get_option("crud_group_alibaba_pid", ''),
            // 接口加密方式
            'encryptType' => get_option("crud_group_alibaba_encryptType", 1),
            //支付宝网关url
            'alipayUli' => get_option("crud_group_alibaba_alipayUli", 'https://openapi.alipaydev.com/gateway.do'),
            //支付网关
            'gateway' => get_option("crud_group_alibaba_gateway", ''),
            // 授权回调url
            'authorizationCallbackUil' => get_option("crud_group_alibaba_authorizationCallbackUil", ''),


            /************ 公钥模式 **************/
            // 支付宝公钥
            'alipayPublicKey' => get_option("crud_group_alibaba_alipayPublicKey", 'key/alipayPublicKey_RSA2.txt'),
            // app公钥
            'appPublicKey' => get_option("crud_group_alibaba_appPublicKey", 'key/appPublicKey_RSA2048.txt'),
            // app私钥
            'appPrivateKey' => get_option("crud_group_alibaba_appPrivateKey", 'key/appPrivateKey_RSA2048.txt'),

            /************ 证书模式 **************/
            // app公钥证书
            'appPublicCert' => get_option("crud_group_alibaba_appPublicCert", 'certificate/appPublicCert.crt'),
            // app证书私钥
            'appPrivateCertKey' => get_option("crud_group_alibaba_appPrivateCertKey", 'certificate/appPublicCertKey.txt'),
            // 支付宝公钥证书
            'alipayPublicCert' => get_option("crud_group_alibaba_alipayPublicCert", '/certificate/alipayPublicCert.crt'),
            //支付宝根证书
            'alipayRootCert' => get_option("crud_group_alibaba_alipayRootCert", '/certificate/alipayRootCert.crt'),

            /******** 接口内容加密 ***********/
            // 接口内容加密方式
            'contentEncryptType' => get_option("crud_group_alibaba_contentEncryptType", 0),
            // 接口内容加解密密钥
            'contentSecretKey' => get_option("crud_group_alibaba_contentSecretKey", ''),


        ],
    ],

];