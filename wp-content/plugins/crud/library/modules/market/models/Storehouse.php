<?php

namespace crud\modules\market\models;

use Yii;
/**
 * This is the model class for table "wp_storehouse".
 *
 * @property int $id
 * @property string|null $username 发件人
 * @property string|null $phone 手机号
 * @property string|null $province 省
 * @property string|null $city 市
 * @property string|null $district 区
 * @property string|null $address_info 详细地址
 * @property string|null $status 是否默认
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Storehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_storehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 5],
            [['phone'], 'string', 'max' => 11],
            [['province', 'city', 'district', 'address_info'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('market', 'ID'),
            'username' => Yii::t('market', 'Username'),
            'phone' => Yii::t('market', 'Phone'),
            'province' => Yii::t('market', 'Province'),
            'city' => Yii::t('market', 'City'),
            'district' => Yii::t('market', 'District'),
            'address_info' => Yii::t('market', 'Address Info'),
            'status' => Yii::t('market', 'Status'),
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
            ['field' =>'username', 'title' => Yii::t('market', 'Username')],
            ['field' =>'phone', 'title' => Yii::t('market', 'Phone')],
            ['field' =>'province', 'title' => Yii::t('market', 'Province')],
            ['field' =>'city', 'title' => Yii::t('market', 'City')],
            ['field' =>'district', 'title' => Yii::t('market', 'District')],
            ['field' =>'address_info', 'title' => Yii::t('market', 'Address Info')],
            ['field' =>'status', 'title' => Yii::t('market', 'Status')],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"formatter"=>'datetime',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"formatter"=>'datetime',"style"=>'width: 130px'],
        ];
    }

    //'ID' => '',
    //'Username' => '',
    //'Phone' => '',
    //'Province' => '',
    //'City' => '',
    //'District' => '',
    //'Address Info' => '',
    //'Status' => '',
    //'Created At' => '',
    //'Updated At' => '',
}
