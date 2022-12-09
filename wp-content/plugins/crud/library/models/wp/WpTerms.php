<?php

namespace library\models\wp;

use Yii;

/**
 * This is the model class for table "{{%terms}}".
 *
 * @property int $term_id
 * @property string $name
 * @property string $slug
 * @property int $term_group
 */
class WpTerms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%terms}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['term_group'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'term_id' => Yii::t('wp', 'Term ID'),
            'name' => Yii::t('wp', 'Name'),
            'slug' => Yii::t('wp', 'Slug'),
            'term_group' => Yii::t('wp', 'Term Group'),
        ];
    }
}
