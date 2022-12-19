<?php
/**
 *
 * @package crud
 */

return [
    'components' => [
        "ads" => [
            "class" => "crud\modules\ads\components\Ads",
            "clientId" => get_option("crud_group_ads_clientId"),
            "developerToken" => get_option("crud_group_ads_developerToken"),
            "clientSecret" => get_option("crud_group_ads_clientSecret"),
            "customerId" => get_option("crud_group_ads_customerId"),
            "accountId" => get_option("crud_group_ads_accountId"),
            "oAuthRefreshTokenPath" => get_option("crud_group_ads_oAuthRefreshTokenPath"),
            "redirect_uri" => get_option("crud_group_ads_redirect_uri"),
            "adGroupId" => get_option("crud_group_ads_adGroupId"),
            'oAuthScope'=>get_option("crud_group_ads_oAuthScope"),
        ],
        "flows" => [
            "class" => "crud\modules\ads\components\Flows",
            "apiKey" =>  get_option("crud_group_flows_apiKey"),
            "domain" =>  get_option("crud_group_flows_domain"),
        ],
    ],

];