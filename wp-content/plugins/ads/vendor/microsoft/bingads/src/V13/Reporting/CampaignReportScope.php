<?php

namespace Microsoft\BingAds\V13\Reporting;

{
    /**
     * Defines a campaign to include in the report.
     * @link https://docs.microsoft.com/en-us/advertising/reporting-service/campaignreportscope?view=bingads-13 CampaignReportScope Data Object
     * 
     * @used-by AccountThroughAdGroupReportScope
     * @used-by AccountThroughCampaignReportScope
     */
    final class CampaignReportScope
    {
        /**
         * The identifier of the account that the campaign belongs to.
         * @var integer
         */
        public $AccountId;

        /**
         * The identifier of the campaign to limit the scope to.
         * @var integer
         */
        public $CampaignId;
    }

}
