<?php

namespace crud\modules\pay\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wp_order".
 *
 * @property int $id
 * @property string $pal_type 支付场景
 * @property int|null $user_id 支付场景
 * @property string $order_id 订单id
 * @property string|null $subject 标题
 * @property float|null $total_amount 订单金额
 * @property float|null $receipt_amount 实收金额
 * @property string|null $trade_no 支付流水号
 * @property int|null $notify_number 通知次数
 * @property string $notify_url 异步通知url
 * @property string|null $return_url 同步跳转url
 * @property int|null $status 支付状态
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Order extends ActiveRecord
{

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
            [['pal_type', 'order_id', 'notify_url'], 'required'],
            [['user_id', 'notify_number', 'status', 'created_at', 'updated_at'], 'integer'],
            [['total_amount', 'receipt_amount'], 'number'],
            [['pal_type'], 'string', 'max' => 10],
            [['order_id', 'subject', 'trade_no', 'notify_url', 'return_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pay', 'ID'),
            'pal_type' => Yii::t('pay', 'Pal Type'),
            'user_id' => Yii::t('pay', 'User ID'),
            'order_id' => Yii::t('pay', 'Order ID'),
            'subject' => Yii::t('pay', 'Subject'),
            'total_amount' => Yii::t('pay', 'Total Amount'),
            'receipt_amount' => Yii::t('pay', 'Receipt Amount'),
            'trade_no' => Yii::t('pay', 'Trade No'),
            'notify_number' => Yii::t('pay', 'Notify Number'),
            'notify_url' => Yii::t('pay', 'Notify Url'),
            'return_url' => Yii::t('pay', 'Return Url'),
            'status' => Yii::t('pay', 'Status'),
            'created_at' => Yii::t('pay', 'Created At'),
            'updated_at' => Yii::t('pay', 'Updated At'),
        ];
    }

    public function columns(){
        return [
            ['field' => 'id', 'title' => Yii::t('pay', 'ID'),"style"=>'width: 20px'],
            ['field' => 'pal_type', 'title' => Yii::t('pay', 'Pal Type'),"style"=>'width: 80px'],
            ['field' => 'user_id', 'title' => Yii::t('pay', 'User ID'),"style"=>'width: 50px'],
            ['field' => 'order_id', 'title' => Yii::t('pay', 'Order ID'),"style"=>'width: 100px'],
            ['field' => 'subject', 'title' => Yii::t('pay', 'Subject'),"style"=>'width: 100px'],
            ['field' => 'total_amount', 'title' => Yii::t('pay', 'Total Amount'),"style"=>'width: 60px'],
            ['field' => 'receipt_amount', 'title' => Yii::t('pay', 'Receipt Amount'),"style"=>'width: 60px'],
            ['field' => 'trade_no', 'title' => Yii::t('pay', 'Trade No'),"style"=>'width: 100px'],
            ['field' => 'notify_number', 'title' => Yii::t('pay', 'Notify Number'),"style"=>'width: 50px'],
            ['field' => 'notify_url', 'title' => Yii::t('pay', 'Notify Url'),"style"=>'width: 100px'],
            ['field' => 'return_url', 'title' => Yii::t('pay', 'Return Url'),"style"=>'width: 100px'],
            ['field' => 'status', 'title' => Yii::t('pay', 'Status'),"formatter"=>'status',"style"=>'width: 50px','statusList'=>['未支付','已支付']],
            ['field' => 'created_at', 'title' => Yii::t('pay', 'Created At'),"formatter"=>'datetime',"style"=>'width: 100px'],
            ['field' => 'updated_at', 'title' => Yii::t('pay', 'Updated At'),"formatter"=>'datetime',"style"=>'width: 100px'],
        ];
    }
}
