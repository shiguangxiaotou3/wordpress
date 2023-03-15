<?php

namespace crud\modules\pay\models;

use Yii;
/**
 * This is the model class for table "wp_order".
 *
 * @property int $id
 * @property string $palType 支付场景
 * @property int $user_id 支付场景
 * @property string $orderId 订单id
 * @property string $subject 标题
 * @property float $money 金额
 * @property string $notifyUrl 异步通知url
 * @property string $returnUrl 同步跳转url
 * @property string|null $status 支付状态
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['palType', 'user_id', 'orderId', 'subject', 'money', 'notifyUrl', 'returnUrl'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['money'], 'number'],
            [['palType'], 'string', 'max' => 10],
            [['orderId', 'subject', 'notifyUrl', 'returnUrl', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'palType' => 'Pal Type',
            'user_id' => 'User ID',
            'orderId' => 'Order ID',
            'subject' => 'Subject',
            'money' => 'Money',
            'notifyUrl' => 'Notify Url',
            'returnUrl' => 'Return Url',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
