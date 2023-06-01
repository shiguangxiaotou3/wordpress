<?php
/** @var $this yii\web\View */
/** @var $model crud\modules\pay\models\Order */
/** @var $url string */
/** @var $file array */
/** @var $code  */
use crud\widgets\PageHeaderWidget;
use crud\assets\EchartAsset;
use crud\assets\VueAsset;
wp_enqueue_media();
VueAsset::register($this);

$rules =get_option('rewrite_rules');
?>
<div class="wrap">
    <?= PageHeaderWidget::widget([]) ?>
    <table class="wp-list-table widefat fixed striped table-view-list" style="margin-top: 20px">
        <thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <td  class="manage-column"><span>正则</span></td>
            <td  class="manage-column"><span>重写规则</span></td>
        </tr>
        </thead>
        <tbody id="the-list">
        <?php if(is_array($rules)){foreach ($rules as $key =>$rule){?>
            <tr >
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-1">选择</label>
                    <input id="cb-select-1" type="checkbox" name="post[]" :value="item.id">
                    <div class="locked-indicator">
                        <span class="locked-indicator-icon" aria-hidden="true"></span>
                    </div>
                </th>
                <td class="manage-column" data-colname="名称"><?= $key ?></td>
                <td class="manage-column" data-colname="名称"><?= $rule ?></td>

            </tr>
        <?php }  }?>
        </tbody>
        <tfoot>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <td  class="manage-column"><span>正则</span></td>
            <td  class="manage-column"><span>重写规则</span></td>
        </tr>
        </tfoot>
    </table>
</div>
