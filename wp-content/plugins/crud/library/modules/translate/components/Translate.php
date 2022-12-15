<?php


namespace crud\modules\translate\components;

interface Translate
{


    /**
     * @param $data
     * @param string $from
     * @param string $to
     * @param string $format
     * @param string $model
     * @return mixed
     */
    public function translate($data,$from ="en",$to="zh-CHS",$format = "text", $model = "");

    /**
     * @return mixed
     */
    public static function error($code);

    /**
     * @return mixed
     */
    public function languages();


    /**
     * @return mixed
     */
    public function shortcut();
}