<?php
/** @var $this yii\web\View */

use crud\widgets\CodeEditorWidget;
$css =<<<CSS
kbd {
    padding: 2px 4px;
    /*font-size: 90%;*/
    color: #fff;
    background-color: #333;
    border-radius: 3px;
}
#basePath  {
    text-align: center;
    margin-bottom: 2px;
    margin-top: 2px;
}
#basePath  li:first-child{
    width: 28px;height: 28px;
    line-height: 28px;
    border-radius: 14px;
    vertical-align: middle;
    background-color: #ededed;
    border: 1px solid rgb(220,220,222);
}
#basePath  li:first-child:hover{
    background-color: rgb(220,220,222);
    border: 1px solid rgb(34,113,177);
    
}
#basePath li:first-child span{
    margin: 4px 4px;
}
#basePath li:first-child span:hover{
    color: rgb(34,113,177);
}

#editorMenu{
margin: 4px 0px 5px 5px;
    padding:0;
    opacity:initial;
    background-color: #fff;
    color: #222;
    border-radius:3px;
    filter: drop-shadow(0 1px 3px rgba(77, 77, 77, 0.5));
    position:fixed; top:100px;left: 300px;
    /*box-shadow: 0px 2px 2px 2px  rgb(200,200,200);*/
}
#editorMenu:hover{
 /*box-shadow: 0px 1px 1px 1px  rgb(200,200,200);*/
}
#editorMenu >ul{
   margin: 0;
}
#editorMenu >ul >li{
    cursor: pointer;
    line-height: 30px;
    /*border: 0;*/
    /*border-radius: 0;*/
    /*background-color: transparent;*/
    /*display: flex;*/
    /*align-items: flex-start;*/
    /*height: auto;*/
    /*margin: 0;*/
    font-weight: normal;
    /*box-shadow: none;*/
    width: 100%;
    color: #222;
    white-space: nowrap;
}
#editorMenu >ul >li:hover{
    background-color: #e6f3fa;
}
#editorMenu >ul >li>label{
    padding-right: 14px;
}
#editorMenu >.menuitem{
    cursor: pointer;
    white-space: nowrap;
}
.menuitem > .dashicons{
 margin:5px 5px;
}
CSS;
$this->registerCss($css);
?>

<div class="wrap" style="position:relative">
    <h1>编辑器</h1>
    <hr class='wp-header-end' />
    <ul class="subsubsub" id="basePath">
        <li><span class="dashicons dashicons-admin-home"></span></li>
    </ul>
    <form class="search-form search-plugins" method="get">
        <p class="search-box" style="">
            <label class="screen-reader-text" for="plugin-search-input">文件:</label>
            <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value=""
                   placeholder="搜索文件" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
        </p>
    </form>
    <hr style='width: 100%;' />
    <?= CodeEditorWidget::widget(["options" => ["id" => "editor", "style" => "margin: 6.5px 0;width: 100%;min-height: 500px"]]); ?>
    <div class="menu" id="editorMenu" style="display: none">
        <ul>
            <li>
                <label  class="menuitem" data-action="upload" title="" tabindex="0">
                    <span class="dashicons dashicons-admin-page"></span>
                    <span class="displayname" >新建文件</span>
                </label>
            </li>
            <li>
                <label  class="menuitem" data-action="upload" title="" tabindex="0">
                    <span  class="dashicons dashicons-admin-page"></span>
                    <span class="displayname">新建目录</span>
                </label>
            </li>

        </ul>
    </div>
</div>
