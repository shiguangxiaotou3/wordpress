<?php

namespace crud\modules\wp\models;

use Yii;

/**
 * This is the model class for table "{{%commentmeta}}".
 *
 * @property int $meta_id
 * @property int $comment_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 */
class WpCommentmeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%commentmeta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id'], 'integer'],
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
            'comment_id' => Yii::t('wp', 'Comment ID'),
            'meta_key' => Yii::t('wp', 'Meta Key'),
            'meta_value' => Yii::t('wp', 'Meta Value'),
        ];
    }
}
