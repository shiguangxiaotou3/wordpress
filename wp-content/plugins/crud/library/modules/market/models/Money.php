<?php

namespace crud\modules\market\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wp_money".
 *
 * @property int $id
 * @property int|null $user_id 用户id
 * @property float|null $money 金额
 * @property float|null $before 变更前
 * @property float|null $after 变更后
 * @property string|null $remarks 注释
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Money extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_money';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['money', 'before', 'after'], 'number'],
            [['remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('market', 'ID'),
            'user_id' => Yii::t('market', 'User ID'),
            'money' => Yii::t('market', 'Money'),
            'before' => Yii::t('market', 'Before'),
            'after' => Yii::t('market', 'After'),
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
            ['field' =>'user_id', 'title' => Yii::t('market', 'User ID')],
            ['field' =>'money', 'title' => Yii::t('market', 'Money')],
            ['field' =>'before', 'title' => Yii::t('market', 'Before')],
            ['field' =>'after', 'title' => Yii::t('market', 'After')],
            ['field' =>'remarks', 'title' => Yii::t('market', 'Remarks')],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
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


}
