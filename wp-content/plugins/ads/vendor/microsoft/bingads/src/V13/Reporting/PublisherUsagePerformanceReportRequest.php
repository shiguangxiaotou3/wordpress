<?php

namespace Microsoft\BingAds\V13\Reporting;

{
    /**
     * Defines a publisher usage performance report request.
     * @link https://docs.microsoft.com/en-us/advertising/reporting-service/publisherusageperformancereportrequest?view=bingads-13 PublisherUsagePerformanceReportRequest Data Object
     * 
     * @uses ReportAggregation
     * @uses PublisherUsagePerformanceReportColumn
     * @uses PublisherUsagePerformanceReportFilter
     * @uses AccountThroughAdGroupReportScope
     * @uses ReportTime
     */
    final class PublisherUsagePerformanceReportRequest extends ReportRequest
    {
        /**
         * The type of aggregation to use to aggregate the report data.
         * @var ReportAggregation
         */
        public $Aggregation;

        /**
         * The list of attributes and performance statistics to include in the report.
         * @var PublisherUsagePerformanceReportColumn[]
         */
        public $Columns;

        /**
         * The filter information to use to filter the report data.
         * @var PublisherUsagePerformanceReportFilter
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
