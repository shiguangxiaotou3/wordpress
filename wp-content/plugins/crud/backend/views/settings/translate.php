<?php
/** @var $this yii\web\View */

use yii\web\View;
use crud\widgets\PreCodeWidget;
use crud\models\SettingsSwitch;
use crud\widgets\ControllerActionsWidget;



$action = Yii::$app->controller->id."/".Yii::$app->controller->action->id;
$nonce=wp_create_nonce( 'post_like_nonce' );
$csrf = Yii::$app->request->getCsrfToken();
$time =time();
$js=<<<JS
 $("#source").change(function (){
     let tmp_data ={
           nonce:"{$nonce}",
            action: "{$action}",
            num: "{$time}",
             _csrf: "{$csrf}",
             
            data: "asdas"
        };
      console.log(ajaxurl,tmp_data);
    $.post(
        ajaxurl, tmp_data, 
        function (response) {
            $("#results code").html(response.data);
            console.log(response);
            console.log(document.querySelectorAll("#results>code"));
            hljs.highlightBlock(document.querySelectorAll("#results>code")[0]);
        },
        "json"
    )   
});
JS;
$this->registerJs($js);

?>


<div class="wrap">
    <h1 class="wp-heading-inline">
        <?=  get_admin_page_parent() ?>
        <small><?php echo esc_html( get_admin_page_title() ); ?></small>
    </h1>
    <hr class="wp-header-end" />
    <?php settings_errors(); ?>
    <?= ControllerActionsWidget::widget(["filter" =>function($action){return SettingsSwitch::getSwitch($action);}]); ?>
    <form class="search-form search-plugins" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
            <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
        </p>
    </form>
    <hr style="width: 100%;" />
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_translate");
        do_settings_sections("settings/translate");
        submit_button();
        ?>
    </form>
    <hr style="width: 100%;" />
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">待翻译的文本</th>
                <td>
                    <textarea name="text" rows="5" cols="50" id="txt" class="large-text code" placeholder="待输入的文字"></textarea>
                    <p>多个文本使用换行或"\n"</p>
                    <?= PreCodeWidget::widget([
                        "options" => ['id' => "results", "class" => "large-text code"],
                        "language" => "json",
                        "code" => ""]);
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">源语言</th>
                <td>
                    <select id="source" class="regular-text code" name="source" placeholder="文件语言"
                            aria-describedby="timezone-description">
                        <option value="auto1">自动识别1</option>
                        <option value="auto2">自动识别2</option>
                        <option value="auto3">自动识别3</option>
                        <optgroup label="自动识别">
                        </optgroup>
                        <optgroup label="可用">
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">目标语言</th>
                <td>
                    <select id="target" class="regular-text code" name="target" placeholder="目标语言"
                            aria-describedby="timezone-description">
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>







