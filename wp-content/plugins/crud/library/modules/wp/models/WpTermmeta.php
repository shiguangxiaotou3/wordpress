<?php

namespace crud\modules\wp\models;

use Yii;

/**
 * This is the model class for table "{{%termmeta}}".
 *
 * @property int $meta_id
 * @property int $term_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 */
class WpTermmeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%termmeta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['term_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => Yii::t('wp', 'Meta ID'),
            'term_id' => Yii::t('wp', 'Term ID'),
            'meta_key' => Yii::t('wp', 'Meta Key'),
            'meta_value' => Yii::t('wp', 'Meta Value'),
        ];
    }
}
