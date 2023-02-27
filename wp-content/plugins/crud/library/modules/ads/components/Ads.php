<?php
namespace crud\modules\ads\components;

use Yii;
use yii\base\Component;
use Microsoft\BingAds\Auth\OAuthScope;
use Microsoft\BingAds\Auth\ServiceClient;
use Microsoft\BingAds\Auth\ApiEnvironment;
use Microsoft\BingAds\Auth\ServiceClientType;
use Microsoft\BingAds\Auth\AuthorizationData;
use Microsoft\BingAds\Auth\OAuthTokenRequestException;
use Microsoft\BingAds\V13\CampaignManagement\AddAdsRequest;
use Microsoft\BingAds\Auth\OAuthDesktopMobileAuthCodeGrant;
use Microsoft\BingAds\V13\CustomerManagement\GetUserRequest;
use Microsoft\BingAds\V13\CampaignManagement\UpdateAdsRequest;
use Microsoft\BingAds\V13\CampaignManagement\AdEditorialStatus;
use Microsoft\BingAds\V13\CustomerManagement\GetAccountRequest;
use Microsoft\BingAds\V13\CampaignManagement\AddAdGroupsRequest;
use Microsoft\BingAds\V13\CampaignManagement\AddKeywordsRequest;
use Microsoft\BingAds\V13\CustomerManagement\GetCustomerRequest;
use Microsoft\BingAds\V13\CampaignManagement\UpdateAdGroupsRequest;
use Microsoft\BingAds\V13\CampaignManagement\UpdateKeywordsRequest;
use Microsoft\BingAds\V13\CampaignManagement\AddAdExtensionsRequest;
use Microsoft\BingAds\V13\CustomerManagement\GetAccountsInfoRequest;
use Microsoft\BingAds\V13\CampaignManagement\GetAdGroupsByIdsRequest;
use Microsoft\BingAds\V13\CustomerManagement\GetCustomersInfoRequest;
use Microsoft\BingAds\V13\CampaignManagement\GetAdsByAdGroupIdRequest;
use Microsoft\BingAds\V13\CampaignManagement\GetKeywordsByAdGroupIdRequest;
use Microsoft\BingAds\V13\CampaignManagement\GetBMCStoresByCustomerIdRequest;



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
    public $customerId='';
    public $accountId='';
    public $adGroupId='';
    public $campaignId='';
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
        return  $this->_authorizationData;
    }

    /**
     * 重配置文件中实力话AuthorizationData
     */
    public function setAuthorizationData(){
        try {
            $this->_authorizationData = (new AuthorizationData())
                ->withAccountId($this->accountId)
                ->withCustomerId($this->customerId)
                ->withAuthentication($this->authentication)
                ->withDeveloperToken($this->developerToken);
            $refreshToken= $this->ReadOAuthRefreshToken();
            if($refreshToken != null){
                echo "刷新Access Token".time()."\n\n\n";
                $this->_authorizationData->Authentication->RequestOAuthTokensByRefreshToken($refreshToken);
                $this->WriteOAuthRefreshToken($this->_authorizationData->Authentication->OAuthTokens->RefreshToken);
            }
            return $this->_authorizationData;
        }catch(OAuthTokenRequestException $e) {
            //Yii::log($e->Error."=>".$e->Description);
        }
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
        if( !isset( $this->_adInsightProxy) or empty($this->_adInsightProxy)){
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
        if( !isset( $this->_customerManagementProxy) or empty($this->_customerManagementProxy)){
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
        if( !isset( $this->_bulkProxy) or empty($this->_bulkProxy)){
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
        if( !isset( $this->_campaignManagementProxy) or empty($this->_campaignManagementProxy)){
            $this->setCampaignManagementProxy();
        }
        return $this->_campaignManagementProxy;
    }
    public function setCampaignManagementProxy(){
        $this->_campaignManagementProxy = new ServiceClient(
            ServiceClientType::CampaignManagementVersion13,
            $this->authorizationData,
            $this->apiEnvironment
        );
    }
    public function getReportingProxy(){
        if( !isset( $this->_reportingProxy) or empty($this->_reportingProxy)){
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
        if( !isset( $this->_customerBillingManagementProxy) or empty($this->_customerBillingManagementProxy)){
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

    /**
     * @return \string[][]
     */
    public static function actions(){
        return  [
            ['action' => 'AddAdExtensions', 'description' => 'Adds one or more ad extensions to an account\'s ad extension library.', 'request_Limits' => '1 AccountId,100 AdExtensions'],
            ['action' => 'AddAdGroupCriterions', 'description' => 'Adds one or more ad group criterions.', 'request_Limits' => '1 AccountId,1,000 AdGroupCriterions'],
            ['action' => 'AddAdGroups', 'description' => 'Adds new ad groups to a specified campaign.', 'request_Limits' => '1,000 AdGroups,1 CampaignId'],
            ['action' => 'AddAds', 'description' => 'Adds one or more ads to an ad group.', 'request_Limits' => '1 AdGroupId,50 Ads'],
            ['action' => 'AddAudiences', 'description' => 'Adds one or more audiences.', 'request_Limits' => '100 Audiences'],
            ['action' => 'AddBidStrategies', 'description' => 'Adds bid strategies to an account\'s portfolio bid strategy library.', 'request_Limits' => '100 BidStrategies'],
            ['action' => 'AddBudgets', 'description' => 'Adds new budgets to the account\'s shared budget library.', 'request_Limits' => '100 Budgets'],
            ['action' => 'AddCampaignConversionGoals', 'description' => 'Reserved.', 'request_Limits' => '0'],
            ['action' => 'AddCampaignCriterions', 'description' => 'Adds one or more campaign criterions that help determine whether ads in each campaign get served.', 'request_Limits' => '100 CampaignCriterions'],
            ['action' => 'AddCampaigns', 'description' => 'Adds one or more campaigns to the specified account.', 'request_Limits' => '1 AccountId,100 Campaigns'],
            ['action' => 'AddConversionGoals', 'description' => 'Adds new conversion goals to the account\'s shared conversion goal library.', 'request_Limits' => '100 ConversionGoals'],
            ['action' => 'AddExperiments', 'description' => 'Adds experiments and creates experiment campaigns based on existing campaigns in an account.', 'request_Limits' => '100 Experiments'],
            ['action' => 'AddImportJobs', 'description' => 'Creates a new import job.', 'request_Limits' => '1 ImportJobs'],
            ['action' => 'AddKeywords', 'description' => 'Adds one or more keywords to an ad group.', 'request_Limits' => '1 AdGroupId,1,000 Keywords'],
            ['action' => 'AddLabels', 'description' => 'Adds one or more labels to an account.', 'request_Limits' => '100 Labels'],
            ['action' => 'AddListItemsToSharedList', 'description' => 'Adds negative keywords to a negative keyword list, or negative sites to a website exclusion list.', 'request_Limits' => '1 SharedList,5,000 ListItems'],
            ['action' => 'AddMedia', 'description' => 'Adds the specified media to an account\'s media library.', 'request_Limits' => '1 AccountId,10 Media'],
            ['action' => 'AddNegativeKeywordsToEntities', 'description' => 'Adds negative keywords to the specified campaign or ad group.', 'request_Limits' => '1 EntityNegativeKeywords,Each EntityNegativeKeywordelement can contain up to 20,000 negative keywords.'],
            ['action' => 'AddSharedEntity', 'description' => 'Adds a negative keyword list to the ad account library, or adds a website exclusion list to the manager account (customer) library.', 'request_Limits' => '1 SharedEntity,5,000 ListItems'],
            ['action' => 'AddUetTags', 'description' => 'Adds new Universal Event Tracking (UET) tags that you can add to your website to allow Microsoft Advertising to collect actions people take on your website.', 'request_Limits' => '100 UetTags'],
            ['action' => 'AddVideos', 'description' => 'Adds one or more videos to an account.', 'request_Limits' => '100 Videos'],
            ['action' => 'AppealEditorialRejections', 'description' => 'Appeals ads or keywords that failed editorial review.', 'request_Limits' => '1,000 EntityIdToParentIdAssociations'],
            ['action' => 'ApplyOfflineConversionAdjustments', 'description' => 'Applies offline conversion adjustments.', 'request_Limits' => '1,000 OfflineConversionAdjustments'],
            ['action' => 'ApplyOfflineConversions', 'description' => 'Applies offline conversions for the account with Microsoft Click Id among other offline conversion data.', 'request_Limits' => '1,000 OfflineConversions'],
            ['action' => 'ApplyProductPartitionActions', 'description' => 'Applies an add, update, or delete action to each of the specified BiddableAdGroupCriterionor NegativeAdGroupCriterion, which each contain a ProductPartition.', 'request_Limits' => '5,000 CriterionActions'],
            ['action' => 'DeleteAdExtensions', 'description' => 'Deletes one or more ad extensions from the account\'s ad extension library.', 'request_Limits' => '1 AccountId,100 AdExtensionIds'],
            ['action' => 'DeleteAdExtensionsAssociations', 'description' => 'Removes the specified association from the respective campaigns or ad groups.', 'request_Limits' => '100 AdExtensionIdToEntityIdAssociations 1 AccountId'],
            ['action' => 'DeleteAdGroupCriterions', 'description' => 'Deletes the specified ad group criterions.', 'request_Limits' => '1 AccountId,1,000 AdGroupCriterionIds'],
            ['action' => 'DeleteAdGroups', 'description' => 'Deletes one or more ad groups from the specified campaign.', 'request_Limits' => '1,000 AdGroupIds,1 CampaignId'],
            ['action' => 'DeleteAds', 'description' => 'Deletes one or more ads from the specified ad group.', 'request_Limits' => '1 AdGroupId,50 AdIds'],
            ['action' => 'DeleteAudiences', 'description' => 'Deletes the specified audiences.', 'request_Limits' => '100 AudienceIds'],
            ['action' => 'DeleteBidStrategies', 'description' => 'Deletes bid strategies from an account\'s portfolio bid strategy library.', 'request_Limits' => '100 BidStrategyIds'],
            ['action' => 'DeleteBudgets', 'description' => 'Deletes budgets from the account\'s shared budget library.', 'request_Limits' => '100 BudgetIds'],
            ['action' => 'DeleteCampaignConversionGoals', 'description' => 'Reserved.', 'request_Limits' => ''],
            ['action' => 'DeleteCampaignCriterions', 'description' => 'Deletes one or more campaign criterions.', 'request_Limits' => '100 CampaignCriterionIds'],
            ['action' => 'DeleteCampaigns', 'description' => 'Deletes one or more campaigns in a specified account.', 'request_Limits' => '1 AccountId,100 CampaignIds'],
            ['action' => 'DeleteExperiments', 'description' => 'Deletes one or more experiments.', 'request_Limits' => '100 ExperimentIds'],
            ['action' => 'DeleteImportJobs', 'description' => 'Deletes the import jobs.', 'request_Limits' => '1 ImportJobs'],
            ['action' => 'DeleteKeywords', 'description' => 'Deletes one or more keywords in a specified ad group.', 'request_Limits' => '1 AdGroupId,1,000 KeywordIds'],
            ['action' => 'DeleteLabelAssociations', 'description' => 'Deletes label associations.', 'request_Limits' => '100 LabelAssociations'],
            ['action' => 'DeleteLabels', 'description' => 'Deletes one or more labels from the account.', 'request_Limits' => '100 LabelIds'],
            ['action' => 'DeleteListItemsFromSharedList', 'description' => 'Deletes negative keywords from a negative keyword list, or negative sites from a website exclusion list.', 'request_Limits' => '1 SharedList,5,000 ListItemIds'],
            ['action' => 'DeleteMedia', 'description' => 'Deletes the specified media from an account\'s media library.', 'request_Limits' => '1 AccountId,100MediaIds'],
            ['action' => 'DeleteNegativeKeywordsFromEntities', 'description' => 'Deletes negative keywords from the specified campaign or ad group.', 'request_Limits' => '1 EntityNegativeKeywords,Each EntityNegativeKeywordelement can contain up to 20,000 negative keywords.'],
            ['action' => 'DeleteSharedEntities', 'description' => 'Deletes negative keyword lists from the ad account library, or deletes website exclusion lists from the manager account (customer) library.', 'request_Limits' => '20 SharedEntities'],
            ['action' => 'DeleteSharedEntityAssociations', 'description' => 'Deletes the negative keyword list to campaign associations, or website exclusion list to ad account associations.', 'request_Limits' => '10,000 Associations'],
            ['action' => 'DeleteVideos', 'description' => 'Deletes one or more videos from the account.', 'request_Limits' => '100 VideoIds'],
            ['action' => 'GetAccountMigrationStatuses', 'description' => 'Gets the migration status info for the specified accounts.', 'request_Limits' => '1,000 AccountIds'],
            ['action' => 'GetAccountProperties', 'description' => 'Gets account level properties by name.', 'request_Limits' => 'Not applicable'],
            ['action' => 'GetAdExtensionIdsByAccountId', 'description' => 'Gets the ad extensions from the account\'s ad extension library.', 'request_Limits' => '1 AccountId'],
            ['action' => 'GetAdExtensionsAssociations', 'description' => 'Gets the respective ad extension associations by the specified campaign and ad group identifiers.', 'request_Limits' => '1 AccountId,100 EntityIds'],
            ['action' => 'GetAdExtensionsByIds', 'description' => 'Gets the specified ad extensions from the account\'s ad extension library.', 'request_Limits' => '1 AccountId,100 AdExtensionIds'],
            ['action' => 'GetAdExtensionsEditorialReasons', 'description' => 'Gets reasons for ad extension editorial issues.', 'request_Limits' => '1 AccountId,100 AdExtensionIdToEntityIdAssociations'],
            ['action' => 'GetAdGroupCriterionsByIds', 'description' => 'Gets ad group criterions by identifiers and types.', 'request_Limits' => '1 AccountId,1,000 AdGroupCriterionIds'],
            ['action' => 'GetAdGroupsByCampaignId', 'description' => 'Gets the ad groups within the specified campaign.', 'request_Limits' => '1 CampaignId'],
            ['action' => 'GetAdGroupsByIds', 'description' => 'Gets the specified ad groups within the specified campaign.', 'request_Limits' => '1,000 AdGroupIds,1 CampaignId'],
            ['action' => 'GetAdsByAdGroupId', 'description' => 'Retrieves the ads within an ad group.', 'request_Limits' => '1 AdGroupId'],
            ['action' => 'GetAdsByEditorialStatus', 'description' => 'Retrieves the ads that belong to the specified ad group and have the specified editorial review status.', 'request_Limits' => '1 AdGroupId'],
            ['action' => 'GetAdsByIds', 'description' => 'Retrieves the specified ads from the specified ad group.', 'request_Limits' => '1 AdGroupId,20 AdIds'],
            ['action' => 'GetAudiencesByIds', 'description' => 'Retrieves the specified audiences from the specified account.', 'request_Limits' => '100 AudienceIds'],
            ['action' => 'GetBidStrategiesByIds', 'description' => 'Gets bid strategies in an account\'s portfolio bid strategy library.', 'request_Limits' => '100 BidStrategyIds'],
            ['action' => 'GetBMCStoresByCustomerId', 'description' => 'Gets the Microsoft Merchant Center stores for the specified customer.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetBSCCountries', 'description' => 'Gets the list of supported sales country codes for Microsoft Shopping Campaigns.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetBudgetsByIds', 'description' => 'Gets the specified budgets from the account\'s shared budget library.', 'request_Limits' => '100 BudgetIds'],
            ['action' => 'GetCampaignCriterionsByIds', 'description' => 'Gets the specified campaign criterions.', 'request_Limits' => '100 CampaignCriterionIds,1 CampaignId'],
            ['action' => 'GetCampaignIdsByBidStrategyIds', 'description' => 'Gets the campaign identifiers that are associated with the specified portfolio bid strategies.', 'request_Limits' => '100 BidStrategyIds'],
            ['action' => 'GetCampaignIdsByBudgetIds', 'description' => 'Gets the campaign identifiers that share each specified budget.', 'request_Limits' => '100 BudgetIds'],
            ['action' => 'GetCampaignsByAccountId', 'description' => 'Gets the campaigns within an account.', 'request_Limits' => '1 AccountId'],
            ['action' => 'GetCampaignsByIds', 'description' => 'Gets the specified campaigns within an account.', 'request_Limits' => '1 AccountId,100 CampaignIds'],
            ['action' => 'GetConversionGoalsByIds', 'description' => 'Gets the specified conversion goals.', 'request_Limits' => '100 ConversionGoalIds'],
            ['action' => 'GetConversionGoalsByTagIds', 'description' => 'Gets the conversion goals that use the specified UET tags.', 'request_Limits' => '100 TagIds'],
            ['action' => 'GetEditorialReasonsByIds', 'description' => 'Gets the reasons why the specified entities failed editorial review and whether the issue is appealable.', 'request_Limits' => '1 AccountId,1,000 EntityIdToParentIdAssociations'],
            ['action' => 'GetExperimentsByIds', 'description' => 'Gets experiments by experiment identifiers.', 'request_Limits' => '5,000 ExperimentIds'],
            ['action' => 'GetFileImportUploadUrl', 'description' => 'GetFileImportUploadUrl is reserved for future use.', 'request_Limits' => ''],
            ['action' => 'GetGeoLocationsFileUrl', 'description' => 'Gets a temporary URL that you can use to download a file that contains identifiers for the geographical locations that you can target or exclude.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetImportEntityIdsMapping', 'description' => 'Gets mappings of your source entity IDs to Microsoft Advertising entity IDs.', 'request_Limits' => '100 SourceEntityIds'],
            ['action' => 'GetImportJobsByIds', 'description' => 'Gets import jobs by their type and identifiers.', 'request_Limits' => '100 ImportJobIds'],
            ['action' => 'GetImportResults', 'description' => 'Gets results for import jobs completed within the last 90 days.', 'request_Limits' => '100 ImportJobIds'],
            ['action' => 'GetKeywordsByAdGroupId', 'description' => 'Gets the keywords within an ad group.', 'request_Limits' => '1 AdGroupId'],
            ['action' => 'GetKeywordsByEditorialStatus', 'description' => 'Retrieves the keywords with the specified editorial review status.', 'request_Limits' => '1 AdGroupId'],
            ['action' => 'GetKeywordsByIds', 'description' => 'Retrieves the specified keywords.', 'request_Limits' => '1 AdGroupId,1,000 KeywordIds'],
            ['action' => 'GetLabelAssociationsByEntityIds', 'description' => 'Gets label associations by entity identifiers.', 'request_Limits' => '100 EntityIds'],
            ['action' => 'GetLabelAssociationsByLabelIds', 'description' => 'Gets label associations by label identifiers.', 'request_Limits' => '1 LabelIds'],
            ['action' => 'GetLabelsByIds', 'description' => 'Gets labels by label identifiers.', 'request_Limits' => '1,000 LabelIds'],
            ['action' => 'GetListItemsBySharedList', 'description' => 'Gets the negative keywords of a negative keyword list, or negative sites of a website exclusion list.', 'request_Limits' => '1 SharedList'],
            ['action' => 'GetMediaAssociations', 'description' => 'Gets the media associations of the specified entity type from an account\'s media library.', 'request_Limits' => '1 AccountId,100 MediaIds'],
            ['action' => 'GetMediaMetaDataByAccountId', 'description' => 'Gets the media meta data of the specified entity type from an account\'s media library.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetMediaMetaDataByIds', 'description' => 'Gets the specified media meta data from an account\'s media library.', 'request_Limits' => '100 MediaIds'],
            ['action' => 'GetNegativeKeywordsByEntityIds', 'description' => 'Gets the negative keywords that are assigned directly to campaigns or ad groups.', 'request_Limits' => '1 ParentEntityId,1 EntityIds'],
            ['action' => 'GetNegativeSitesByAdGroupIds', 'description' => 'Gets the negative sites URLs that are assigned directly to ad groups.', 'request_Limits' => '15 AdGroupIds,1 CampaignId'],
            ['action' => 'GetNegativeSitesByCampaignIds', 'description' => 'Gets the negative site URLs that are assigned directly to campaigns.', 'request_Limits' => '1 AccountId,15 CampaignIds'],
            ['action' => 'GetProfileDataFileUrl', 'description' => 'Gets a temporary URL that you can use to download industry or job function profile data.', 'request_Limits' => '1 ProfileType'],
            ['action' => 'GetSharedEntities', 'description' => 'Gets negative keyword lists or website exclusion lists.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetSharedEntitiesByAccountId', 'description' => 'Gets negative keyword lists.', 'request_Limits' => 'Not applicable.'],
            ['action' => 'GetSharedEntityAssociationsByEntityIds', 'description' => 'Gets the negative keyword list to campaign associations by campaign IDs, or website exclusion list to ad account associations by ad account IDs.', 'request_Limits' => '100 EntityIds'],
            ['action' => 'GetSharedEntityAssociationsBySharedEntityIds', 'description' => 'Gets the negative keyword list to campaign associations by negative keyword list IDs, or website exclusion list to ad account associations by website exclusion list IDs.', 'request_Limits' => '1 SharedEntityIds'],
            ['action' => 'GetUetTagsByIds', 'description' => 'Gets the specified Universal Event Tracking (UET) tags.', 'request_Limits' => '100 TagIds'],
            ['action' => 'GetVideosByIds', 'description' => 'Gets videos by video identifiers.', 'request_Limits' => '1,000 VideoIds'],
            ['action' => 'SearchCompanies', 'description' => 'Search for profile data by company name.', 'request_Limits' => '1 CompanyNameFilter'],
            ['action' => 'SetAccountProperties', 'description' => 'Sets account level properties by name.', 'request_Limits' => 'Not applicable'],
            ['action' => 'SetAdExtensionsAssociations', 'description' => 'Associates the specified ad extensions with the respective campaigns or ad groups.', 'request_Limits' => '1 AccountId,100 AdExtensionIdToEntityIdAssociations'],
            ['action' => 'SetLabelAssociations', 'description' => 'Sets label associations.', 'request_Limits' => '100 LabelAssociations'],
            ['action' => 'SetNegativeSitesToAdGroups', 'description' => 'Sets the negative site URLs directly to ad groups.', 'request_Limits' => '5,000 AdGroupNegativeSites,1 CampaignId'],
            ['action' => 'SetNegativeSitesToCampaigns', 'description' => 'Sets the negative site URLs directly to campaigns.', 'request_Limits' => '1 AccountId,5,000 CampaignNegativeSites'],
            ['action' => 'SetSharedEntityAssociations', 'description' => 'Sets the negative keyword list to campaign associations, or website exclusion list to ad account associations.', 'request_Limits' => '10,000 Associations'],
            ['action' => 'UpdateAdExtensions', 'description' => 'Updates one or more ad extensions within an account\'s ad extension library.', 'request_Limits' => '1 AccountId,100 AdExtensions'],
            ['action' => 'UpdateAdGroupCriterions', 'description' => 'Updates one or more ad group criterions.', 'request_Limits' => '1 AccountId,1 CampaignId'],
            ['action' => 'UpdateAdGroups', 'description' => 'Updates the specified ad groups in a campaign.', 'request_Limits' => '1,000 AdGroups,1 CampaignId'],
            ['action' => 'UpdateAds', 'description' => 'Updates the specified ads within an ad group.', 'request_Limits' => '1 AdGroupId,50 Ads'],
            ['action' => 'UpdateAudiences', 'description' => 'Updates the specified audiences.', 'request_Limits' => '100 Audiences'],
            ['action' => 'UpdateBidStrategies', 'description' => 'Updates bid strategies in an account\'s portfolio bid strategy library.', 'request_Limits' => '100 BidStrategies'],
            ['action' => 'UpdateBudgets', 'description' => 'Updates the specified budgets in the account\'s shared budget library.', 'request_Limits' => '100 Budgets'],
            ['action' => 'UpdateCampaignCriterions', 'description' => 'Updates one or more campaign criterions.', 'request_Limits' => '100 CampaignCriterions'],
            ['action' => 'UpdateCampaigns', 'description' => 'Updates specified campaigns in a specified account.', 'request_Limits' => '1 AccountId,100 Campaigns'],
            ['action' => 'UpdateConversionGoals', 'description' => 'Updates conversion goals within the account\'s shared conversion goal library.', 'request_Limits' => '100 ConversionGoals'],
            ['action' => 'UpdateExperiments', 'description' => 'Updates the specified experiments.', 'request_Limits' => '100 Experiments'],
            ['action' => 'UpdateImportJobs', 'description' => 'Replaces the specified import jobs with new import jobs.', 'request_Limits' => '1 ImportJobs'],
            ['action' => 'UpdateKeywords', 'description' => 'Updates the keywords within a specified ad group.', 'request_Limits' => '1 AdGroupId,1,000 Keywords'],
            ['action' => 'UpdateLabels', 'description' => 'Updates the labels within the account.', 'request_Limits' => '100 Labels'],
            ['action' => 'UpdateSharedEntities', 'description' => 'Updates the negative keyword lists or website exclusion lists.', 'request_Limits' => '20 SharedEntities'],
            ['action' => 'UpdateUetTags', 'description' => 'Updates the specified Universal Event Tracking (UET) tags.', 'request_Limits' => '100 UetTags'],
            ['action' => 'UpdateVideos', 'description' => 'Updates the videos within the account.', 'request_Limits' => '100 Videos'],
        ];
    }
    public function GetCustomer(){
        $require = new GetCustomerRequest();
        $require->CustomerId=$this->customerId;
        return $this->customerManagementProxy->GetService()->GetCustomer($require);

    }
    /**
     * 获取从指定客户那里访问的标识符、名称和帐户数量。
     * @param $customerId
     * @param bool $onlyParentAccounts
     * @return mixed
     */
    public function GetAccountsInfo($customerId, $onlyParentAccounts=true){
        $request = new GetAccountsInfoRequest();
        $request->CustomerId = $customerId;
        $request->OnlyParentAccounts = $onlyParentAccounts;
        return $this->customerManagementProxy->GetService()->GetAccountsInfo($request);
    }
    /**
     * 获取客户信息
     * @param $customerId
     * @return mixed
     */
    public function GetCustomerInfo($customerId){

        $require = new GetCustomersInfoRequest();
        $require->CustomerId=$customerId;
        return $this->customerManagementProxy->GetService()->GetCustomer($require);
    }
    /**
     * 向帐户的广告扩展库添加一个或多个广告扩展.
     * @param $accountId
     * @param $adExtensions
     * @return mixed
     */
    public function AddAdExtensions($accountId, $adExtensions){
        $adExtensions =[
            //广告扩展的唯一Microsoft广告标识符
            "Id"=>self::uuid(),
            "Status"=>AdEditorialStatus::Active,

        ];
        $request = new AddAdExtensionsRequest();
        $request->AccountId = $accountId;
        $request->AdExtensions = $adExtensions;

        return $this->campaignManagementProxy->GetService()->AddAdExtensions($request);
    }
    //向广告组中添加一个或多个广告.
    public function AddAdGroups($campaignId, $adGroups, $returnInheritedBidStrategyTypes){
        $CampaignId = self::uuid();
        $request = new AddAdGroupsRequest();
        $request->CampaignId = $campaignId;
        $request->AdGroups = $adGroups;
        $request->ReturnInheritedBidStrategyTypes = $returnInheritedBidStrategyTypes;
        return $this->campaignManagementProxy->GetService()->AddAdGroups($request);
    }
    public function AddAds($adGroupId, $ads=[]){
        //  $adGroupId ="1229254305018244";
        //$this->authorizationData->withCustomerId(162676995)->withAccountId(151076986);
        /** @var ServiceClient $server */
        $request = new AddAdsRequest();
        $request->AdGroupId = $adGroupId;
        $request->Ads = $ads;
        return $this->campaignManagementProxy->GetService()->AddAds($request);
    }
    public function  AddKeywords($adGroupId, $keywords, $returnInheritedBidStrategyTypes = true){
        $request = new AddKeywordsRequest();
        $request->AdGroupId = $adGroupId;
        $request->Keywords = $keywords;
        $request->ReturnInheritedBidStrategyTypes = $returnInheritedBidStrategyTypes;
        return  $this->campaignManagementProxy->GetService()->AddKeywords($request);
    }
    public static function uuid(){
        return Yii::$app->db->createCommand("select uuid() as uuid")->queryOne()['uuid'];
    }
    public function GetAdsByAdGroupId($adGroupId, $adTypes=[], $returnAdditionalFields=''){
        if(empty($adTypes)){
            $adTypes =['Text',"Image","Product","AppInstall","ExpandedText",
                "DynamicSearch","ResponsiveAd","ResponsiveSearch"];
        }
        $request = new GetAdsByAdGroupIdRequest();
        $request->AdGroupId = $adGroupId;
        $request->AdTypes = $adTypes;
        $request->ReturnAdditionalFields = $returnAdditionalFields;
        return $this->campaignManagementProxy->GetService()->GetAdsByAdGroupId($request);
    }
    public function UpdateAds($adGroupId, $ads=[]){
        $this->authorizationData->withAccountId($this->accountId)->withCustomerId($this->customerId);
        $request = new UpdateAdsRequest();
        $request->AdGroupId = $adGroupId;
        $request->Ads = $ads;
        return $this->campaignManagementProxy->GetService()->UpdateAds($request);
    }
    public function GetAdGroupsByIds($campaignId, $adGroupIds, $returnAdditionalFields=''){
        $request = new GetAdGroupsByIdsRequest();
        $request->CampaignId = $campaignId;
        $request->AdGroupIds = $adGroupIds;
        $request->ReturnAdditionalFields = $returnAdditionalFields;
        return $this->campaignManagementProxy->GetService()->GetAdGroupsByIds($request);
    }
    public function GetKeywordsByAdGroupId($adGroupId){
        $request = new GetKeywordsByAdGroupIdRequest();
        $request->AdGroupId = $adGroupId;
        return $this->campaignManagementProxy->GetService()->GetKeywordsByAdGroupId($request);
    }

    public function UpdateKeywords($adGroupId, $keywords, $returnInheritedBidStrategyTypes=true){
        $request = new UpdateKeywordsRequest();
        $request->AdGroupId = $adGroupId;
        $request->Keywords = $keywords;
        $request->ReturnInheritedBidStrategyTypes = $returnInheritedBidStrategyTypes;
        return $this->campaignManagementProxy ->GetService()->UpdateKeywords($request);
    }
    public function UpdateAdGroups($campaignId, $adGroups, $updateAudienceAdsBidAdjustment=false, $returnInheritedBidStrategyTypes=false)
    {

        $request = new UpdateAdGroupsRequest();
        $request->CampaignId = $campaignId;
        $request->AdGroups = $adGroups;
        $request->UpdateAudienceAdsBidAdjustment = $updateAudienceAdsBidAdjustment;
        $request->ReturnInheritedBidStrategyTypes = $returnInheritedBidStrategyTypes;

        return $this->campaignManagementProxy->GetService()->UpdateAdGroups($request);
    }
}


