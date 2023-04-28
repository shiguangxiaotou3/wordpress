<?php

namespace crud\modules\market\models;

use Yii;
/**
 * This is the model class for table "wp_commodity_price".
 *
 * @property int $id
 * @property int|null $commodity_id 商品id
 * @property int|null $publish_id 发布人
 * @property int|null $publish_time 发布时间
 * @property int|null $publish_price 发布时间
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class CommodityPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_commodity_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commodity_id', 'publish_id', 'publish_time', 'publish_price', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('market', 'ID'),
            'commodity_id' => Yii::t('market', 'Commodity ID'),
            'publish_id' => Yii::t('market', 'Publish ID'),
            'publish_time' => Yii::t('market', 'Publish Time'),
            'publish_price' => Yii::t('market', 'Publish Price'),
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
            ['field' =>'commodity_id', 'title' => Yii::t('market', 'Commodity ID')],
            ['field' =>'publish_id', 'title' => Yii::t('market', 'Publish ID')],
            ['field' =>'publish_time', 'title' => Yii::t('market', 'Publish Time')],
            ['field' =>'publish_price', 'title' => Yii::t('market', 'Publish Price')],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
        ];
    }

    //'ID' => '',
    //'Commodity ID' => '',
    //'Publish ID' => '',
    //'Publish Time' => '',
    //'Publish Price' => '',
    //'Created At' => '',
    //'Updated At' => '',
}
