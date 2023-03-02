<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\widgets\PageHeaderWidget;
use crud\library\widgets\JvectormapVisitorsWidget;
use crud\library\widgets\JvectormapMarkersWidget;
use crud\assets\JvectormapAsset;

JvectormapAsset::register($this);

$css = <<<CSS
 .map{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}
.map_item{
    margin: 10px auto;
    width: 480px ;height:270px;
     /*width: 960px ;height:540px;*/
    background-color: rgb(220,220,220);
}
CSS;
$this->registerCss($css);
$crawlers = Yii::$app->crawlers;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
    <?php
        settings_fields("crud_group_jvectormap");
        do_settings_sections("base/index/jvectormap");
        submit_button();
    ?>
    </form>
    <div style="display: flex;">
        <div id="showJvectormap" style="margin: 10px; width: 480px ;height:270px; background-color: rgb(220,220,220);"> </div>
        <textarea id="ips_text" style="margin: 10px; width: 480px ;height:270px; " class="large-text code" placeholder="ip地址查询.多个ip','隔开">123.56.7.206</textarea>
    </div>
    <button id="select" class="button button-primary">查询</button>
    <div class="map">
    <?php
        echo JvectormapVisitorsWidget::widget([
            "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
            "options" => ["id" => 'world_visitors', "class" => "map_item"],
            "visitorsData" => $crawlers->JvectormapVisitors(7)
        ]);
        echo JvectormapMarkersWidget::widget([
            "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
            "options" => ["id" => 'world_markers', "class" => "map_item"],
            "markersData" => $crawlers->JvectormapMarkers(7),
        ]);
        echo JvectormapMarkersWidget::widget([
            "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
            "options" => ["id" => 'cn_markers', "class" => "map_item"],
            "mapFile" => "/maps/region/cn/cn_merc.js",
            "mapName" => "cn_merc",
            "markersData" => $crawlers->JvectormapMarkers(7, "CN"),
        ]);
    ?>
    </div>
</div>

<?php

$ajaxUrl = admin_url('admin-ajax.php')."?action=base/index/jvectormap";
$js =<<<JS
  var crudAjax = "{$ajaxUrl}";
  showJvectormap("showJvectormap","");
  $("#select").on("click" ,function(){
      let ips = $("#ips_text").val();
      if((ips !== "") && (ips !== undefined)){
        $.get(crudAjax,{'ips':ips},function(res,status,xhr){
          console.log(res);
          if(res.code ==1){
             $('#showJvectormap').children().remove();
            showJvectormap("showJvectormap",res.data);
          }else{
            console.log(res,status,xhr);
            alert(res.message)
          }
         }
        )
      }
  });
  function showJvectormap(id,markers){
   let  options ={
    map              : 'world-merc',
    normalizeFunction: 'polynomial',
    hoverOpacity     : 0.7,
    hoverColor       : false,
    backgroundColor  : '#1d1f21',
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
    markers          : "",
     onMarkerTipShow: function(event, label, index){
        label.html('<b>'+data.metro.names[index]+'</b><br/>'+'<b>Population:</b>'+data.metro.population[val][index]+'</br>'+'<b>Unemployment rate: </b>'+data.metro.unemployment[val][index]+'%');
    },
    onRegionTipShow: function(event, label, code){
        label.html('<b>'+label.html()+'</b></br>'+'<b>Unemployment rate: </b>'+data.states[val][code]+'%');}
};
   options.markers =markers;
   $('#'+id).vectorMap( options);
}

JS;
$this->registerJs($js);

