<?php

namespace Microsoft\BingAds\V13\CustomerManagement;

{
    /**
     * Defines a Customer Management Ad API fault detail object that operations return when generic errors occur, such as an authentication error.
     * @link https://docs.microsoft.com/en-us/advertising/customer-management-service/adapifaultdetail?view=bingads-13 AdApiFaultDetail Data Object
     * 
     * @uses AdApiError
     */
    final class AdApiFaultDetail extends ApplicationFault
    {
        /**
         * An array of AdApiError objects that contains the details that explain why the service operation failed.
         * @var AdApiError[]
         */
        public $Errors;
    }

}
