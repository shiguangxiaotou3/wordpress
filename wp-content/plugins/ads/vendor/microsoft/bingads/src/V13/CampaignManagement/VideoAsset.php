<?php

namespace Microsoft\BingAds\V13\CampaignManagement;

{
    /**
     * Defines the VideoAsset Data Object.
     * @link https://docs.microsoft.com/en-us/advertising/campaign-management-service/videoasset?view=bingads-13 VideoAsset Data Object
     * 
     * @uses ImageAsset
     */
    final class VideoAsset extends Asset
    {
        /**
         * Reserved.
         * @var string
         */
        public $SubType;

        /**
         * Reserved.
         * @var ImageAsset
         */
        public $ThumbnailImage;
    }

}
