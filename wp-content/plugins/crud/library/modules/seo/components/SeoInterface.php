<?php


namespace crud\modules\seo\components;


interface SeoInterface
{


    /**
     * @param $urls
     * @return mixed
     */
    public function send($urls);

    /**
     * @return mixed
     */
    public function getUrl();

    /**
     * @param array $options
     * @return mixed
     */
    public function getQuery($options=[]);
}