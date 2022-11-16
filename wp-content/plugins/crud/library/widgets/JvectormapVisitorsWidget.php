<?php


namespace crud\library\widgets;


use crud\assets\JvectormapAsset;
use ParagonIE\Sodium\Core\Curve25519\H;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * 地区统计
 * @package crud\library\widgets
 */
class JvectormapVisitorsWidget extends  Widget
{

    public $options=[];
    public $jvectormapOptions=[];
    public $_defaultOptions=[
        "backgroundColor" => 'transparent',
        "regionStyle" => [
            "initial" => [
                "fill" => '#e4e4e4',
                'fill-opacity' => 1,
                "stroke" => 'none',
                'stroke-width' => 0,
                'stroke-opacity' => 1
            ]
        ],
        "series" => [
            "regions" => [
                [
                    "values" => "visitorsData",
                    "scale" => ['#92c1dc', '#ebf4f9'],
                    "normalizeFunction" => 'polynomial'
                ]
            ]
        ],
        "onRegionLabelShow" => "function (e, el, code) {if (typeof visitorsData[code] != 'undefined'){el.html(el.html() + ': ' + visitorsData[code] + ' new visitors'); } }",
        //"onRegionTipShow"=> "function(e, el, code){el.html(el.html()+' (GDP - '+gdpData[code]+')');}"
    ];
    public $mapFile="/maps/city/world/world-merc.js";
    public $mapName='world-merc';
    public $visitorsData=[
        "US" => 398, // USA
        "SA" => 400, // Saudi Arabia
        "CA" => 1000, // Canada
        "DE" => 500, // Germany
        "FR" => 760, // France
        "CN" => 300, // China
        "AU" => 700, // Australia
        "BR" => 600, // Brazil
        "IN" => 800, // India
        "GB" => 320, // Great Britain
        "RU" => 3000 // Russia
    ];


    /**
     * @return string
     */
    public function run(){
       JvectormapAsset::addJsFile($this->view,$this->mapFile,["depends"=>"crud\assets\JvectormapAsset"]);
       $visitorsData =json_encode($this->visitorsData,true);
       $options = ArrayHelper::merge(['map'=>$this->mapName],$this->_defaultOptions,$this->jvectormapOptions);
       $json_options =json_encode($options,true);
       $json_options =  self::replaceJsonVar($json_options,"visitorsData");
       $json_options =   self::replaceJsonVar($json_options,$options['onRegionLabelShow']);
       $js="var visitorsData = {$visitorsData};$('#{$this->options["id"]}').vectorMap({$json_options});";
       $this->view->registerJs($js);
       return Html::beginTag("div",$this->options).Html::endTag("div");
    }

    /**
     * @param $json
     * @param $varName
     * @return string|string[]
     */
    public static function replaceJsonVar($json,$varName){
        return str_replace(":\"$varName\"",":".$varName,$json);
    }

}
<<<JS
var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
  };
$('#world_visitors').vectorMap({
    map              : 'world-merc',
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial: {
        fill            : '#e4e4e4',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 0,
        'stroke-opacity': 1
      }
    },
    series           : {
      regions: [
        {
          values           : visitorsData,
          scale            : ['#92c1dc', '#ebf4f9'],
          normalizeFunction: 'polynomial'
        }
      ]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != 'undefined'){
         el.html(el.html() + ': ' + visitorsData[code] + ' new visitors'); 
      }
    }
  });
JS;
