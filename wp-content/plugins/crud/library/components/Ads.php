<?php


namespace crud\library\components;




use Microsoft\BingAds\Auth\OAuthTokenRequestException;
use Microsoft\BingAds\Samples\V13\AuthHelper;
use Yii;
use yii\base\Component;
use Microsoft\BingAds\Auth\OAuthScope;
use Microsoft\BingAds\Auth\ApiEnvironment;
use Microsoft\BingAds\Auth\ServiceClient;
use Microsoft\BingAds\Auth\ServiceClientType;
use Microsoft\BingAds\Auth\AuthorizationData;
use Microsoft\BingAds\Auth\OAuthDesktopMobileAuthCodeGrant;

/**
 * Class Ads
 * @property-read OAuthDesktopMobileAuthCodeGrant $authentication
 * @property-read AuthorizationData $authorizationData
 * @property-read $customerManagementProxy 客户管理代理
 * @property-read $adInsightProxy 广告洞察代理
 * @property-read $bulkProxy 批量代理
 * @property-read $campaignManagementProxy 活动管理代理
 * @property-read $reportingProxy 报告管理代理
 * @property-read $customerBillingManagementProxy 客户账单管理代理
 * @property $oAuthRefreshToken
 * @package crud\library\components
 */
class Ads extends Component{
    public $developerToken = "BBD37VB98";
    public $apiEnvironment = ApiEnvironment::Production;
    public $oAuthScope = OAuthScope::MSADS_MANAGE;
    public $oAuthRefreshTokenPath = 'refresh.txt';
    public $clientId = '';
    public $clientSecret ="";
    public $redirect_uri ="";

    private $_authentication = "";
    private $_authorizationData='';


    private $_adInsightProxy;
    private $_bulkProxy;
    private $_campaignManagementProxy;
    private $_customerManagementProxy;
    private $_customerBillingManagementProxy;
    private $_reportingProxy;

    /**
     * @return string
     * @link $authentication
     */
    public function getAuthentication()
    {
        if (!isset($this->_authentication) or empty($this->_authentication)) {
            $this->setAuthentication();
        }
        return $this->_authentication;
    }

    /**
     * @link $authentication
     */
    public function setAuthentication(){
        $this->_authentication = (new OAuthDesktopMobileAuthCodeGrant())
            ->withEnvironment($this->apiEnvironment)
            ->withClientId($this->clientId)
            ->withOAuthScope($this->oAuthScope)
            ->withClientSecret($this->clientSecret)
            ->withRedirectUri($this->redirect_uri);
    }

    /**
     * @link  $authorizationData
     */
    public function getAuthorizationData(){
        if(!isset($this->_authorizationData) or empty($this-> _authorizationData)){
            $this->setAuthorizationData();
        }
        try {
            $refreshToken= $this->ReadOAuthRefreshToken();
            if($refreshToken != null){
                $this->_authorizationData->Authentication->RequestOAuthTokensByRefreshToken($refreshToken);
                $this->WriteOAuthRefreshToken($this->_authorizationData->Authentication->OAuthTokens->RefreshToken);
            }
            return $this->_authorizationData;
        }catch(OAuthTokenRequestException $e) {
            Yii::log($e->Error."=>".$e->Description);
        }

    }

    /**
     * 重配置文件中实力话AuthorizationData
     */
    public function setAuthorizationData(){
        $this->_authorizationData = (new AuthorizationData())
            ->withAuthentication($this->authentication)
            ->withDeveloperToken($this->developerToken);
    }

    /**
     * 从文件中读取token
     * @link $oAuthRefreshToken
     */
    public function ReadOAuthRefreshToken(){
        $path= Yii::getAlias($this->oAuthRefreshTokenPath);
         $refreshToken = null;
        if (file_exists( $path) && filesize( $path) > 0)
        {
            $refreshTokenfile = @\fopen( $path,"r");
            $refreshToken = fread($refreshTokenfile, filesize( $path));
            fclose($refreshTokenfile);
        }

        return $refreshToken;
    }

    /**
     * 刷新token
     * @param $refreshToken
     */
    public function WriteOAuthRefreshToken($refreshToken){
        $path= Yii::getAlias($this->oAuthRefreshTokenPath);
        $refreshTokenfile = @\fopen(  $path,"wb");
        if (file_exists(  $path)) {
            fwrite($refreshTokenfile, $refreshToken);
            fclose($refreshTokenfile);
        }
        return;
    }

    /**
     * 获取token的url
     */
    public function getTokenUrlByCli(){
        return $this->authorizationData->Authentication->GetAuthorizationEndpoint();
    }

    public function getAdInsightProxy(){
        if( isset( $this->_adInsightProxy) and empty($this->_adInsightProxy)){
            $this->setAdInsightProxy();
        }
        return $this->_adInsightProxy;
    }
    public function setAdInsightProxy(){
       $this->_adInsightProxy = new ServiceClient(
            ServiceClientType::AdInsightVersion13,
           $this->authorizationData,
           $this->apiEnvironment
        );
    }
    public function getCustomerManagementProxy(){
        if( isset( $this->_customerManagementProxy) and empty($this->_customerManagementProxy)){
            $this->setCustomerManagementProxy();
        }
        return $this->_customerManagementProxy;

    }
    public function setCustomerManagementProxy(){
        $this->_customerManagementProxy =  new ServiceClient(
            ServiceClientType::CustomerManagementVersion13,
            $this->authorizationData,
            $this->apiEnvironment
        );
    }
    public function getBulkProxy(){
        if( isset( $this->_bulkProxy) and empty($this->_bulkProxy)){
            $this->setBulkProxy();
        }
        return $this->_bulkProxy;
    }
    public function setBulkProxy(){
       $this->_bulkProxy = new ServiceClient(
            ServiceClientType::BulkVersion13,
           $this->authorizationData,
           $this->apiEnvironment
        );
    }
    public function getCampaignManagementProxy(){
        if( isset( $this->_campaignManagementProxy) and empty($this->_campaignManagementProxy)){
            $this->setCampaignManagementProxy();
        }
        return $this->_campaignManagementProxy;
    }
    public function setCampaignManagementProxy(){
        $this->campaignManagementProxy = new ServiceClient(
            ServiceClientType::CampaignManagementVersion13,
            $this->authorizationData,
            $this->apiEnvironment
        );
    }
    public function getReportingProxy(){
        if( isset( $this->_reportingProxy) and empty($this->_reportingProxy)){
            $this->setReportingProxy();
        }
        return $this->_reportingProxy;
    }
    public function setReportingProxy(){
        $this->_reportingProxy = new ServiceClient(
            ServiceClientType::ReportingVersion13,
            $this->authorizationData,
            $this->apiEnvironment
        );
    }
    public function getCustomerBillingManagementProxy(){
        if( isset( $this->_customerBillingManagementProxy) and empty($this->_customerBillingManagementProxy)){
            $this->setCustomerBillingManagementProxy();
        }
        return $this->_reportingProxy;
    }
    public function setCustomerBillingManagementProxy(){
        $this->customerBillingManagementProxy = new ServiceClient(
            ServiceClientType::CustomerBillingVersion13,
            $this->authorizationData,
            $this->apiEnvironment
        );
    }
}