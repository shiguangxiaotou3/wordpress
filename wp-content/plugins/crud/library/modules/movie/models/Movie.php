<?php

namespace crud\modules\movie\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "wp_movie".
 *
 * @property int $id
 * @property string $movie_url url
 * @property string $movie_name 片名
 * @property string|null $translated_name 译名
 * @property string|null $original_name 原名
 * @property string|null $country 国家
 * @property int|null $start 星星
 * @property string|null $asset 文件
 * @property integer|null $year 年份
 * @property string|null $score_imdb IMDB
 * @property string|null $score_douban IMDB
 * @property string|null $category 类别
 * @property string|null $keywords 关键字
 * @property string|null $release_date 上映日期
 * @property string|null $img 海报
 * @property string|null $bt 链接
 * @property string|null $director 导演
 * @property string|null $describe 简介
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Movie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_movie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['movie_url' ,'movie_name'], 'required'],
            [['movie_url', 'bt', 'asset','describe'], 'string'],
            [['created_at', 'updated_at','start','year'], 'integer'],
            [['movie_name','asset', 'translated_name','original_name', 'country', 'score_imdb', 'score_douban', 'category', 'keywords', 'release_date', 'img', 'director'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    # 创建之前
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    # 修改之前
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                #设置默认值
                'value' => time()
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('movie', 'ID'),
            'movie_url' => Yii::t('movie', 'Movie Url'),
            'movie_name' => Yii::t('movie', 'Movie Name'),
            'translated_name' => Yii::t('movie', 'Translated Name'),
            'original_name'=>'原名',
            'country' => Yii::t('movie', 'Country'),
            'score_imdb' => Yii::t('movie', 'Score Imdb'),
            'score_douban' => Yii::t('movie', 'Score Douban'),
            'category' => Yii::t('movie', 'Category'),
            'keywords' => Yii::t('movie', 'Keywords'),
            'release_date' => Yii::t('movie', 'Release Date'),
            'img' => Yii::t('movie', 'Img'),
            'bt' => Yii::t('movie', 'Bt'),
            'start'=>'星星',
            'year'=>'年份',
            'asset'=>'文件',
            'director' => Yii::t('movie', 'Director'),
            'describe' => Yii::t('movie', 'Describe'),
            'created_at' => Yii::t('movie', 'Created At'),
            'updated_at' => Yii::t('movie', 'Updated At'),
        ];
    }

    public function columns()
    {
        return [
            ['field' =>'id' , 'title' => Yii::t('movie', 'ID')],
            ['field' =>'movie_url' , 'title' =>Yii::t('movie', 'Movie Url'),'dataType'=>'url'],
            ['field' =>'movie_name', 'title' => Yii::t('movie', 'Movie Name')],
            //original_name
            ['field' =>'original_name' , 'title' => '原名'],

//            ['field' =>'translated_name' , 'title' => Yii::t('movie', 'Translated Name')],
            ['field' =>'country' , 'title' => Yii::t('movie', 'Country')],
            ['field' =>'score_imdb' , 'title' => Yii::t('movie', 'Score Imdb')],
            ['field' =>'score_douban' , 'title' => Yii::t('movie', 'Score Douban')],
            ['field' =>'start' , 'title' =>'星星'],
            ['field' =>'year', 'title' =>'年份'],
            ['field' =>'asset', 'title' =>'文件'],
            ['field' =>'category', 'title' => Yii::t('movie', 'Category')],
            ['field' =>'keywords', 'title' => Yii::t('movie', 'Keywords')],
            ['field' =>'release_date' , 'title' => Yii::t('movie', 'Release Date')],
            ['field' =>'img' , 'title' =>Yii::t('movie', 'Img'),'dataType'=>'url'],
            ['field' =>'bt' , 'title' => Yii::t('movie', 'Bt'),'dataType'=>'url'],
            ['field' =>'director' , 'title' => Yii::t('movie', 'Director')],
            ['field' => 'describe' , 'title' => Yii::t('movie', 'Describe'),'dataType'=>'json'],
//            ['field' =>'created_at' , 'title' => Yii::t('movie', 'Created At')],
//            ['field' =>'updated_at', 'title' => Yii::t('movie', 'Updated At')],
        ];
    }
}
