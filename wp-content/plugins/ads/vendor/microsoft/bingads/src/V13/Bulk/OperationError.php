<?php

namespace Microsoft\BingAds\V13\Bulk;

{
    /**
     * Defines a Bulk operation error object that contains the details that explain why the service operation failed.
     * @link https://docs.microsoft.com/en-us/advertising/bulk-service/operationerror?view=bingads-13 OperationError Data Object
     * 
     * @used-by ApiFaultDetail
     * @used-by GetBulkDownloadStatusResponse
     * @used-by GetBulkUploadStatusResponse
     * @used-by UploadEntityRecordsResponse
     */
    final class OperationError
    {
        /**
         * A numeric error code that identifies the error.
         * @var integer
         */
        public $Code;

        /**
         * A message that provides additional details about the error.
         * @var string
         */
        public $Details;

        /**
         * A symbolic string constant that identifies the error.
         * @var string
         */
        public $ErrorCode;

        /**
         * A message that describes the error.
         * @var string
         */
        public $Message;
    }

}
