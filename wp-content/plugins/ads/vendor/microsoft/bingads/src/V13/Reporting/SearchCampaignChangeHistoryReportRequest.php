<?php

namespace Microsoft\BingAds\V13\Reporting;

{
    /**
     * Defines a change history report request.
     * @link https://docs.microsoft.com/en-us/advertising/reporting-service/searchcampaignchangehistoryreportrequest?view=bingads-13 SearchCampaignChangeHistoryReportRequest Data Object
     * 
     * @uses SearchCampaignChangeHistoryReportColumn
     * @uses SearchCampaignChangeHistoryReportFilter
     * @uses AccountThroughAdGroupReportScope
     * @uses ReportTime
     */
    final class SearchCampaignChangeHistoryReportRequest extends ReportRequest
    {
        /**
         * The list of attributes and performance statistics to include in the report.
         * @var SearchCampaignChangeHistoryReportColumn[]
         */
        public $Columns;

        /**
         * The filter information to use to filter the report data.
         * @var SearchCampaignChangeHistoryReportFilter
         */
        public $Filter;

        /**
         * The entity scope of the report.
         * @var AccountThroughAdGroupReportScope
         */
        public $Scope;

        /**
         * The time period to use for the report.
         * @var ReportTime
         */
        public $Time;
    }

}
