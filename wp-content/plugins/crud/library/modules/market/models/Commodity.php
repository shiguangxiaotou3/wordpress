<?php

namespace crud\modules\market\models;

use Yii;

/**
 * This is the model class for table "wp_commodity".
 *
 * @property int $id
 * @property int|null $categorize_id 分类id
 * @property string|null $commodity_name 名称
 * @property string|null $commodity_type 型号
 * @property int|null $commodity_color 颜色
 * @property string|null $commodity_storage 存储大小
 * @property string|null $commodity_describe 描述
 * @property string|null $commoditye_image 图片
 * @property string|null $commodity_keyword 关键词
 * @property string|null $remarks 备注
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Commodity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_commodity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categorize_id', 'commodity_color', 'created_at', 'updated_at'], 'integer'],
            [['commodity_name', 'commodity_type', 'commodity_storage', 'commodity_describe', 'commoditye_image', 'commodity_keyword', 'remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('market', 'ID'),
            'categorize_id' => Yii::t('market', 'Categorize ID'),
            'commodity_name' => Yii::t('market', 'Commodity Name'),
            'commodity_type' => Yii::t('market', 'Commodity Type'),
            'commodity_color' => Yii::t('market', 'Commodity Color'),
            'commodity_storage' => Yii::t('market', 'Commodity Storage'),
            'commodity_describe' => Yii::t('market', 'Commodity Describe'),
            'commoditye_image' => Yii::t('market', 'Commoditye Image'),
            'commodity_keyword' => Yii::t('market', 'Commodity Keyword'),
            'remarks' => Yii::t('market', 'Remarks'),
            'created_at' => Yii::t('market', 'Created At'),
            'updated_at' => Yii::t('market', 'Updated At'),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function columns()
    {
        return [
            ['field' =>'id', 'title' => Yii::t('market', 'ID')],
            ['field' =>'categorize_id', 'title' => Yii::t('market', 'Categorize ID')],
            ['field' =>'commodity_name', 'title' => Yii::t('market', 'Commodity Name')],
            ['field' =>'commodity_type', 'title' => Yii::t('market', 'Commodity Type')],
            ['field' =>'commodity_color', 'title' => Yii::t('market', 'Commodity Color')],
            ['field' =>'commodity_storage', 'title' => Yii::t('market', 'Commodity Storage')],
            ['field' =>'commodity_describe', 'title' => Yii::t('market', 'Commodity Describe')],
            ['field' =>'commoditye_image', 'title' => Yii::t('market', 'Commoditye Image')],
            ['field' =>'commodity_keyword', 'title' => Yii::t('market', 'Commodity Keyword')],
            ['field' =>'remarks', 'title' => Yii::t('market', 'Remarks')],
            ['field' =>'created_at', 'title' => Yii::t('market', 'Created At')],
            ['field' =>'updated_at', 'title' => Yii::t('market', 'Updated At')],
        ];
    }

    //'ID' => '',
    //'Categorize ID' => '',
    //'Commodity Name' => '',
    //'Commodity Type' => '',
    //'Commodity Color' => '',
    //'Commodity Storage' => '',
    //'Commodity Describe' => '',
    //'Commoditye Image' => '',
    //'Commodity Keyword' => '',
    //'Remarks' => '',
    //'Created At' => '',
    //'Updated At' => '',


}
