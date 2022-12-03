<?php

namespace library\models\wp;

use Yii;

/**
 * This is the model class for table "{{%term_taxonomy}}".
 *
 * @property int $term_taxonomy_id
 * @property int $term_id
 * @property string $taxonomy
 * @property string $description
 * @property int $parent
 * @property int $count
 */
class WpTermTaxonomy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%term_taxonomy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['term_id', 'parent', 'count'], 'integer'],
            [['description'], 'required'],
            [['description'], 'string'],
            [['taxonomy'], 'string', 'max' => 32],
            [['term_id', 'taxonomy'], 'unique', 'targetAttribute' => ['term_id', 'taxonomy']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'term_taxonomy_id' => Yii::t('wp', 'Term Taxonomy ID'),
            'term_id' => Yii::t('wp', 'Term ID'),
            'taxonomy' => Yii::t('wp', 'Taxonomy'),
            'description' => Yii::t('wp', 'Description'),
            'parent' => Yii::t('wp', 'Parent'),
            'count' => Yii::t('wp', 'Count'),
        ];
    }
}
