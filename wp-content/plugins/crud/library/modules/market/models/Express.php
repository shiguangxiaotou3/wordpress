<?php

namespace crud\modules\market\models;

use Yii;
/**
 * This is the model class for table "wp_express".
 *
 * @property int $id
 * @property string|null $send_username 发件人
 * @property string|null $send_phone 发件人手机号
 * @property string|null $send_province 发件人省
 * @property string|null $send_city 发件人市
 * @property string|null $send_district 发件人区
 * @property string|null $send_address_info 发详细地址
 * @property string|null $receiving_username 收件人
 * @property string|null $receiving_phone 收件人手机号
 * @property string|null $receiving_province 收件人省
 * @property string|null $receiving_city 收件人市
 * @property string|null $receiving_district 收件人区
 * @property string|null $receiving_address_info 收详细地址
 * @property string|null $body 快递物
 * @property string|null $status 状态
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Express extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_express';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['send_username', 'receiving_username'], 'string', 'max' => 5],
            [['send_phone', 'receiving_phone'], 'string', 'max' => 11],
            [['send_province', 'send_city', 'send_district', 'send_address_info', 'receiving_province', 'receiving_city', 'receiving_district', 'receiving_address_info', 'body'], 'string', 'max' => 255],
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
            'send_username' => Yii::t('market', 'Send Username'),
            'send_phone' => Yii::t('market', 'Send Phone'),
            'send_province' => Yii::t('market', 'Send Province'),
            'send_city' => Yii::t('market', 'Send City'),
            'send_district' => Yii::t('market', 'Send District'),
            'send_address_info' => Yii::t('market', 'Send Address Info'),
            'receiving_username' => Yii::t('market', 'Receiving Username'),
            'receiving_phone' => Yii::t('market', 'Receiving Phone'),
            'receiving_province' => Yii::t('market', 'Receiving Province'),
            'receiving_city' => Yii::t('market', 'Receiving City'),
            'receiving_district' => Yii::t('market', 'Receiving District'),
            'receiving_address_info' => Yii::t('market', 'Receiving Address Info'),
            'body' => Yii::t('market', 'Body'),
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
            ['field' =>'send_username', 'title' => Yii::t('market', 'Send Username')],
            ['field' =>'send_phone', 'title' => Yii::t('market', 'Send Phone')],
            ['field' =>'send_province', 'title' => Yii::t('market', 'Send Province')],
            ['field' =>'send_city', 'title' => Yii::t('market', 'Send City')],
            ['field' =>'send_district', 'title' => Yii::t('market', 'Send District')],
            ['field' =>'send_address_info', 'title' => Yii::t('market', 'Send Address Info')],
            ['field' =>'receiving_username', 'title' => Yii::t('market', 'Receiving Username')],
            ['field' =>'receiving_phone', 'title' => Yii::t('market', 'Receiving Phone')],
            ['field' =>'receiving_province', 'title' => Yii::t('market', 'Receiving Province')],
            ['field' =>'receiving_city', 'title' => Yii::t('market', 'Receiving City')],
            ['field' =>'receiving_district', 'title' => Yii::t('market', 'Receiving District')],
            ['field' =>'receiving_address_info', 'title' => Yii::t('market', 'Receiving Address Info')],
            ['field' =>'body', 'title' => Yii::t('market', 'Body')],
            ['field' =>'status', 'title' => Yii::t('market', 'Status')],
            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"formatter"=>'datetime',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
        ];
    }

    //'ID' => '',
    //'Send Username' => '',
    //'Send Phone' => '',
    //'Send Province' => '',
    //'Send City' => '',
    //'Send District' => '',
    //'Send Address Info' => '',
    //'Receiving Username' => '',
    //'Receiving Phone' => '',
    //'Receiving Province' => '',
    //'Receiving City' => '',
    //'Receiving District' => '',
    //'Receiving Address Info' => '',
    //'Body' => '',
    //'Status' => '',
    //'Created At' => '',
    //'Updated At' => '',
}
