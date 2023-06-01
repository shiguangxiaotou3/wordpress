<?php
/** @var $this yii\web\View */
/** @var $model crud\modules\movie\models\Movie */
use yii\helpers\Html;

if($model){
//    $this->title = $model->movie_name;
//    $this->registerMetaTag([
//        'name' => 'description',
//        'content' => $model->describe,
//    ]);
//
//// 注册关键词标签
//    $this->registerMetaTag([
//        'name' => 'keywords',
//        'content' => $model->keywords,
//    ]);


// 注册其他 meta 标签
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
   foreach ($model as $item){
?>


    <section class="fullscreen">
        <div class="card-50">
            <figure>
                <img src="<?= $item->img ?>" alt="iWatch">
                <figcaption>
                    <a href="/movie/index/list/<?= $item->id ?>" title="<?= $item->movie_name ?>">
                        <svg class="fa-camera">
                            <use xlink:href="#fa-camera"></use>
                        </svg>
                        <?= $item->movie_name ?> (来源于网络)
                    </a>
                </figcaption>
            </figure>
            <!-- end figure-->
            <div class="flex-content">
                <h2><?= $item->movie_name ?></h2>
                <ul class="description">
                    <li>
                        <strong class="text-label">简介:</strong>
                        <pre><code><?= $item->describe ?></code></pre>
                    </li>
                    <li>
                        <strong class="text-label">磁力链接:</strong>
                        <pre><code><?= $item->bt ?></code></pre>
                    </li>
                    <li><strong class="text-label">类型:</strong> <?= $item->keywords ?></li>
                    <li><strong class="text-label">产地:</strong> <?= $item->country ?></li>
                    <li><strong class="text-label">原名:</strong> <?= $item->original_name ?></li>
                    <li><strong class="text-label">IMDB评分:</strong> <?= $item->score_imdb ?></li>
                    <li><strong class="text-label">导演:</strong> <?= $item->director ?></li>
                    <li><strong class="text-label">上映时间:</strong> <?= $item->release_date ?></li>
                </ul>
            </div>
        </div>
    </section>

<?php
    }
}

$this->registerJs('window.ws = new WebSlides();');