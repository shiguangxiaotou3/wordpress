<?php
/** @var $this yii\web\View */

use crud\models\wp\WpUserMeta;
use \crud\models\wp\WpUsers;
use yii\web\View;
use crud\widgets\PageHeaderWidget;
use \crud\modules\market\models\Categorize;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    asdasd
    <?php
//    Categorize::



         $mode =Categorize::find()->where("parent_id = NULL")->all();
         dump($mode);


    ?>
</div>