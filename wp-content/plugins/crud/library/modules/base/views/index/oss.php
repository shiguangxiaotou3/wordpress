<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\widgets\PageHeaderWidget;
use crud\modules\base\components\AliyuncsOss;

?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_aliyuncsOss");
        do_settings_sections("base/index/oss");
        submit_button();
        ?>
    </form>
</div>

<?php
/** @var AliyuncsOss $oss */
$oss = Yii::$app->aliyuncsOss;

//dump( $oss->createBucket("shiguangxiaotou"));

//try{
//dump( $oss->createBucket("shiguangxiaotou2"));
//}catch (Exception $exception){
//    dump($exception);
//}
dump( $oss->bucketList);