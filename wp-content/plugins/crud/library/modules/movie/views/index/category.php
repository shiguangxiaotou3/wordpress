<?php
/** @var $this yii\web\View */
/** @var $model crud\modules\movie\models\Movie */
/** @var $config array */
use yii\helpers\Html;
use crud\modules\movie\models\Movie;
$this->title = '电影分类'." | ". get_option('blogname');

$n = count($config);
$x =0;
$page =ceil($n/4);
for ($i =1;$i<=$page;$i++){
?>


<section>
    <div class="wrap">
        <h2>分类</h2>
        <hr>
        <ul class="flexblock gallery">
            <?php for($li =1;$li<=4;$li++){ ?>
                <?php if(isset($config[$x])){?>
                <li>
                    <a href="/movie/index/search?category=<?= $config[$x]['category'] ?>" title="<?= $config[$x]['category'] ?>">
                        <figure>
                            <img alt="<?= $config[$x]['category'] ?>" src="<?= $config[$x]['img'] ?>">
                            <figcaption>
                                <h2><?= $config[$x]['category'] ?></h2>
                            </figcaption>
                        </figure>
                    </a>
                </li>
                    <?php $keywords[] =$config[$x]['category']?>
                <?php $x++;?>
                <?php }?>
            <?php }?>
        </ul>
    </div>
</section>

<?php
}
$this->registerJs('window.ws = new WebSlides();');
$this->registerMetaTag([
    'name' => 'description',
    'content' => "免费电影资源",
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => join(',',$keywords),
]);
$this->registerMetaTag([
    'name' => 'author',
    'content' => 'shiguangxiaotou',
]);
$this->registerMetaTag([
    'name' => 'language',
    'content' => Yii::$app->language,
]);
$this->registerMetaTag([
    'name' => 'robots',
    'content' => 'index, follow',
]);