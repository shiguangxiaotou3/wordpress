<?php


namespace crud\library\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use crud\assets\JvectormapAsset;





class JvectormapMarkersWidget extends  Widget
{
    public $options=[];
    public $jvectormapOptions=[];
    public $_defaultOptions=[
        "backgroundColor" => 'transparent',
        "normalizeFunction" => 'polynomial',
        "hoverOpacity" => 0.7,
        "hoverColor" => false,
        "regionStyle" => [
            "initial" => [
                "fill" => 'rgba(210, 214, 222, 1)',
                'fill-opacity' => 1,
                "stroke" => 'none',
                'stroke-width' => 0,
                'stroke-opacity' => 1
            ],
            "hover" => [
                'fill-opacity' => 0.7,
                "cursor" => 'pointer'
            ],
            "selected" => [
                "fill" => 'yellow'
            ],
            "selectedHover" => []
        ],
        "markerStyle" => [
            "initial" => [
                "fill" => '#00a65a',
                "stroke" => '#111'
            ]
        ],
       // "onMarkerTipShow"=> "function(event, label, index){console.log(event, label, index)}",
        //"onRegionTipShow"=> "function(event, label, index){console.log(event, label, index)}",

    ];
    public $mapFile="/maps/city/world/world-merc.js";
    public $mapName='world-merc';
    public $markersData=[
        ["latLng" => [41.90, 12.45], "name" => 'Vatican City'],
        ["latLng" => [43.73, 7.41], "name" => 'Monaco'],
        ["latLng" => [-0.52, 166.93], "name" => 'Nauru'],
        ["latLng" => [-8.51, 179.21], "name" => 'Tuvalu'],
        ["latLng" => [43.93, 12.46], "name" => 'San Marino'],
        ["latLng" => [47.14, 9.52], "name" => 'Liechtenstein'],
        ["latLng" => [7.11, 171.06], "name" => 'Marshall Islands'],
        ["latLng" => [17.3, -62.73], "name" => 'Saint Kitts and Nevis'],
        ["latLng" => [3.2, 73.22], "name" => 'Maldives'],
        ["latLng" => [35.88, 14.5], "name" => 'Malta'],
        ["latLng" => [12.05, -61.75], "name" => 'Grenada'],
        ["latLng" => [13.16, -61.23], "name" => 'Saint Vincent and the Grenadines'],
        ["latLng" => [13.16, -59.55], "name" => 'Barbados'],
        ["latLng" => [17.11, -61.85], "name" => 'Antigua and Barbuda'],
        ["latLng" => [-4.61, 55.45], "name" => 'Seychelles'],
        ["latLng" => [7.35, 134.46], "name" => 'Palau'],
        ["latLng" => [42.5, 1.51], "name" => 'Andorra'],
        ["latLng" => [14.01, -60.98], "name" => 'Saint Lucia'],
        ["latLng" => [6.91, 158.18], "name" => 'Federated States of Micronesia'],
        ["latLng" => [1.3, 103.8], "name" => 'Singapore'],
        ["latLng" => [1.46, 173.03], "name" => 'Kiribati'],
        ["latLng" => [-21.13, -175.2], "name" => 'Tonga'],
        ["latLng" => [15.3, -61.38], "name" => 'Dominica'],
        ["latLng" => [-20.2, 57.5], "name" => 'Mauritius'],
        ["latLng" => [26.02, 50.55], "name" => 'Bahrain'],
        ["latLng" => [0.33, 6.73], "name" => 'São Tomé and Príncipe']
    ];


    public function run(){
        JvectormapAsset::addJsFile($this->view,$this->mapFile,["depends"=>"crud\assets\JvectormapAsset"]);
        $options = ArrayHelper::merge(
            ['map'=>$this->mapName, "markers"=>$this->markersData],
            $this->_defaultOptions,$this->jvectormapOptions);
        $json_options =json_encode($options,true);
        //$json_options = self::replaceJsonVar($json_options,$options["onMarkerTipShow"]);
        $js="$('#{$this->options['id']}').vectorMap({$json_options});";
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
$('#world_markers').vectorMap({
    map              : 'world-merc',
    normalizeFunction: 'polynomial',
    hoverOpacity     : 0.7,
    hoverColor       : false,
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial      : {
        fill            : 'rgba(210, 214, 222, 1)',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 0,
        'stroke-opacity': 1
      },
      hover        : {
        'fill-opacity': 0.7,
        cursor        : 'pointer'
      },
      selected     : {
        fill: 'yellow'
      },
      selectedHover: {}
    },
    markerStyle      : {
      initial: {
        fill  : '#00a65a',
        stroke: '#111'
      }
    },
    markers          : [
      { latLng: [41.90, 12.45], name: 'Vatican City' },
      { latLng: [43.73, 7.41], name: 'Monaco' },
      { latLng: [-0.52, 166.93], name: 'Nauru' },
      { latLng: [-8.51, 179.21], name: 'Tuvalu' },
      { latLng: [43.93, 12.46], name: 'San Marino' },
      { latLng: [47.14, 9.52], name: 'Liechtenstein' },
      { latLng: [7.11, 171.06], name: 'Marshall Islands' },
      { latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis' },
      { latLng: [3.2, 73.22], name: 'Maldives' },
      { latLng: [35.88, 14.5], name: 'Malta' },
      { latLng: [12.05, -61.75], name: 'Grenada' },
      { latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines' },
      { latLng: [13.16, -59.55], name: 'Barbados' },
      { latLng: [17.11, -61.85], name: 'Antigua and Barbuda' },
      { latLng: [-4.61, 55.45], name: 'Seychelles' },
      { latLng: [7.35, 134.46], name: 'Palau' },
      { latLng: [42.5, 1.51], name: 'Andorra' },
      { latLng: [14.01, -60.98], name: 'Saint Lucia' },
      { latLng: [6.91, 158.18], name: 'Federated States of Micronesia' },
      { latLng: [1.3, 103.8], name: 'Singapore' },
      { latLng: [1.46, 173.03], name: 'Kiribati' },
      { latLng: [-21.13, -175.2], name: 'Tonga' },
      { latLng: [15.3, -61.38], name: 'Dominica' },
      { latLng: [-20.2, 57.5], name: 'Mauritius' },
      { latLng: [26.02, 50.55], name: 'Bahrain' },
      { latLng: [0.33, 6.73], name: 'São Tomé and Príncipe' }
    ],
     onMarkerTipShow: function(event, label, index){
        label.html('<b>'+data.metro.names[index]+'</b><br/>'+'<b>Population:</b>'+data.metro.population[val][index]+'</br>'+'<b>Unemployment rate: </b>'+data.metro.unemployment[val][index]+'%');
    },
    onRegionTipShow: function(event, label, code){
        label.html('<b>'+label.html()+'</b></br>'+'<b>Unemployment rate: </b>'+data.states[val][code]+'%');}
});
JS;
