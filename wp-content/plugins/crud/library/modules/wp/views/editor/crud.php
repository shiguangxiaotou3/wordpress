<?php
/** @var $this yii\web\View */


use yii\helpers\Markdown;
use crud\widgets\RegisterHighlightAssetWidget;

/** @var $this yii\web\View */
WechatJsSdkAssets::register($this);
RegisterHighlightAssetWidget::widget();
$file = Yii::getAlias("@crud/modules/wp/views/editor/Crud插件文档.md");
$myText = file_get_contents($file );
$css =<<<CSS

body{
 background-color: #e0e0e0;
    margin: 0;padding: 0
}

.header{
    padding: 0 10px;
    border-top-left-radius:5px;
    border-top-right-radius: 8px;
    height: 30px;
    line-height: 30px;
    font-size: 18px;
}
.nav{
    background-color: white;
    width: 100%;height: 50px;
    min-width:  980px;;
    display: flex;
    justify-content:start;
    justify-items: center;
    border-bottom: 1px solid rgb(230,230,230);
    box-shadow: 0px 5px 5px 5px  rgb(230,230,230);
}
.nav:hover{
    box-shadow: 0px 2px 2px 2px  rgb(230,230,230);
}
.nav .nav-item{
    display: flex;
    justify-items: center;
}
.nav .nav-item a{
    padding: 0 10px;
    display: flex;
    margin: auto 5px;
    color: rgb(100,100,100);
    text-decoration: none;
}
.nav .nav-item a:hover{
    font-weight:bold;
    color: rgb(50,50,50);
}


.wrapper{
    width: 940px;min-height: 1330px;
    margin: 20px auto;
    padding: 50px 20px;
    background-color: white;
    box-shadow: 0 0 5px rgb(230,230,230);
}
h2{
    /*color: red;*/
    /*background:#b5cfd2;*/
    border-bottom: 2px solid  silver;
    /*border-bottom-style:outset*/
}
h3{
    color: #0c88b4;
    padding-left: 10px;
    border-left: 8px solid  #0c88b4;
}
h4{
    color:  #c7254e;
    padding-left: 10px;
    border-left: 5px solid  #0c88b4;
    /*border-bottom: 2px solid  #d3d9df;*/
}
h5{
    color: #7f8fa6;
    padding-left: 10px;
    border-left: 2px solid  #7f8fa6;
    /*border-bottom: 2px solid  #d3d9df;*/
}
p{
    margin: 10px ;
}
pre{
    margin: 0 0;
    overflow-x:auto ;
    box-shadow: 0px 5px 5px 5px  rgb(200,200,200);
}
pre:hover{
    box-shadow: 0px 2px 2px 2px  rgb(200,200,200);
}
.hljs .tools{
    float: left;
    margin-left: 10px;
    margin-top: 7px;
    width: 16px;height: 16px;
    border-radius: 8px;
    text-align: center;
}

li code{
    margin: 0 2px;
    padding: 2px 4px;
    border-radius: 5px;
    color: #c7254e;
    background-color: #f9f2f4;
}
p code{
    margin: 0 2px;
    padding: 2px 4px;
    color: #c7254e;
    background-color: #f9f2f4;
    padding: 3px;
    border-radius: 5px;
  
}


.footer{
    width: 100%;height: 50px;
    min-width:  980px;
    border-top:  1px solid rgb(230,230,230);
    background-color: rgb(255,255,255);
    box-shadow: 0px 10px 10px 10px  rgb(230,230,230);
}
.footer div{
    height: 100%;width: 980px;
    margin: 0 auto;
    color: #777;
    line-height: 50px;
}
.footer:hover{
    font-weight:bold;
    color: rgb(20,20,20);
    box-shadow: 0px 5px 5px 5px  rgb(150,150,150);
}
.footer div p {
    padding: 0 20px;
    display:inline
}


/*table {*/
/*    width: 100%;*/
/*    font-family: verdana,arial,sans-serif;*/
/*    font-size:11px;*/
/*    color:#333333;*/
/*    border-width: 1px;*/
/*    border-color: #666666;*/
/*    border-collapse: collapse;*/
/*}*/
/*table th {*/
/*    border-width: 1px;*/
/*    padding: 8px;*/
/*    border-style: solid;*/
/*    border-color: #666666;*/
/*    background-color: #dedede;*/
/*}*/
/*table td {*/
/*    border-width: 1px;*/
/*    padding: 8px;*/
/*    border-style: solid;*/
/*    border-color: #666666;*/
/*    background-color: #ffffff;*/
/*}*/

table {
    width: 100%;
    font-family: verdana,arial,sans-serif;
    font-size:11px;
    color:#333333;
    border-width: 1px;
    border-color: #999999;
    border-collapse: collapse;
     box-shadow: 0px 5px 5px 5px  rgb(200,200,200);
}
table:hover{
    box-shadow: 0px 2px 2px 2px  rgb(200,200,200);
}
table th {
    background:#b5cfd2 ;
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #999999;
}
table td {
    background:#dcddc0 ;
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #999999;
}

/*table {*/
/*    border-collapse: collapse;*/
/*    border-spacing: 0;*/
/*    box-shadow: 0px 5px 5px 5px  rgb(200,200,200);*/
/*}*/
/*table:hover{*/
/*    box-shadow: 0px 2px 2px 2px  rgb(200,200,200);*/
/*}*/
/*td,th {*/
/*    padding: 0;*/
/*}*/
/*table {*/
/*    width: 100%;*/
/*    border-collapse: collapse;*/
/*    border-spacing: 0;*/
/*    empty-cells: show;*/
/*    border: 1px solid #cbcbcb;*/
/*}*/
/*table caption {*/
/*    color: #000;*/
/*    font: italic 85%/1 arial,sans-serif;*/
/*    padding: 1em 0;*/
/*    text-align: center;*/
/*}*/
/*table td,table th {*/
/*    border-left: 1px solid #cbcbcb;*/
/*    border-width: 0 0 0 1px;*/
/*    font-size: inherit;*/
/*    margin: 0;*/
/*    overflow: visible;*/
/*    padding: .5em 1em;*/
/*}*/
/*table thead {*/
/*    background-color: #e0e0e0;*/
/*    color: #000;*/
/*    text-align: left;*/
/*    vertical-align: bottom;*/
/*}*/
/*table td {*/
/*    background-color: transparent;*/
/*}*/
/*table td,.table th {*/
/*    border-width: 0 0 1px 0;*/
/*    border-bottom: 1px solid #cbcbcb;*/
/*}*/
/*table tbody>tr:last-child>td {*/
/*    border-bottom-width: 0;*/
/*}*/

CSS;
$this->registerCss($css );
?>
<div class="wrapper">
    <?php
    dump((new crud\modules\pay\models\Order())->attributeLabels());
    echo Markdown::process($myText, 'gfm-comment')
    ?>
</div>