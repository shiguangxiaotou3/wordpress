<?php

namespace crud\modules\market\models;

use Yii;

/**
 * This is the model class for table "wp_categorize".
 *
 * @property int $id
 * @property int|null $categorize_id 分类id
 * @property int|null $parent_id 父类id
 * @property string|null $categorize_name 名称
 * @property string|null $remarks 备注
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Categorize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_categorize';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categorize_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['categorize_name', 'remarks'], 'string', 'max' => 255],
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
            'parent_id' => Yii::t('market', 'Parent ID'),
            'categorize_name' => Yii::t('market', 'Categorize Name'),
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
            ['field' =>'parent_id', 'title' => Yii::t('market', 'Parent ID')],
            ['field' =>'categorize_name', 'title' => Yii::t('market', 'Categorize Name')],
            ['field' =>'remarks', 'title' => Yii::t('market', 'Remarks')],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"formatter"=>'datetime',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"formatter"=>'datetime',"style"=>'width: 130px'],
        ];
    }

    //'ID' => '',
    //'Categorize ID' => '',
    //'Parent ID' => '',
    //'Categorize Name' => '',
    //'Remarks' => '',
    //'Created At' => '',
    //'Updated At' => '',


}
