<?php

namespace crud\modules\market\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "wp_address".
 *
 * @property int $id
 * @property int|null $user_id 用户id
 * @property string|null $username 姓名
 * @property string|null $phone 手机号
 * @property string|null $province 省
 * @property string|null $city 市
 * @property string|null $district 区
 * @property string|null $address_info 详细地址
 * @property string|null $address_type 收件/寄
 * @property string|null $status 是否默认
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_address';
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
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 5],
            [['phone'], 'string', 'max' => 11],
            [['province', 'city', 'district', 'address_info'], 'string', 'max' => 255],
            [['address_type', 'status'], 'string', 'max' => 1],
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
            'username' => Yii::t('market', 'Username'),
            'phone' => Yii::t('market', 'Phone'),
            'province' => Yii::t('market', 'Province'),
            'city' => Yii::t('market', 'City'),
            'district' => Yii::t('market', 'District'),
            'address_info' => Yii::t('market', 'Address Info'),
            'address_type' => Yii::t('market', 'Address Type'),
            'status' => Yii::t('market', 'Status'),
            'created_at' => Yii::t('market', 'Created At'),
            'updated_at' => Yii::t('market', 'Updated At'),
        ];
    }

    public function columns(){
        return [
            ['field' => 'id', 'title' => Yii::t('market', 'ID'),"style"=>'width: 20px'],
            ['field' => 'user_id', 'title' => Yii::t('market', 'User ID'),"style"=>'width: 50px'],
            ['field' => 'username', 'title' => Yii::t('market', 'Username'),"style"=>'width: 100px'],
            ['field' => 'phone', 'title' => Yii::t('market', 'Phone'),"style"=>'width: 100px'],
            ['field' => 'province', 'title' => Yii::t('market', 'Province'),"style"=>'width: 50px'],
            ['field' => 'city', 'title' => Yii::t('market', 'City'),"style"=>'width: 50px'],
            ['field' => 'district', 'title' => Yii::t('market', 'District'),"style"=>'width: 50px'],
            ['field' => 'address_info', 'title' => Yii::t('market', 'Address Info'),"style"=>'width: 100px'],
            ['field' => 'address_type', 'title' => Yii::t('market', 'Address Type'),"style"=>'width: 50px'],
            ['field' => 'status', 'title' => Yii::t('market', 'Status'),"formatter"=>'status',"style"=>'width: 50px','statusList'=>['未支付','默认']],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
            ];
    }
}
