<?php

namespace crud\modules\pay\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use crud\models\wp\WpUsers;
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
class Order extends ActiveRecord{

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
            [['user_id'],'validateUser'],
            [['order_id'],'unique'],
            [['user_id', 'notify_number', 'status', 'created_at', 'updated_at'], 'integer'],
            [['total_amount', 'receipt_amount'], 'number'],
            [['pal_type'], 'string', 'max' => 15],
            [['order_id', 'subject', 'trade_no', 'notify_url', 'return_url'], 'string', 'max' => 255],
        ];
    }
    public function validateUser($attribute){
        if( WpUsers::find()->where(['Id'=>$this->user_id])->one()){
           return true;
        }else{
            $this->addError($attribute,"#".$this->user_id.'用户不存在');
            return false;
        }
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
            ['field' => 'order_id', 'title' => Yii::t('pay', 'Order ID'),"style"=>'width: 150px'],
            ['field' => 'subject', 'title' => Yii::t('pay', 'Subject'),"style"=>'width: 100px'],
            ['field' => 'total_amount', 'title' => Yii::t('pay', 'Total Amount'),"style"=>'width: 60px'],
            ['field' => 'receipt_amount', 'title' => Yii::t('pay', 'Receipt Amount'),"style"=>'width: 60px'],
            ['field' => 'trade_no', 'title' => Yii::t('pay', 'Trade No'),"style"=>'width: 200px'],
            ['field' => 'notify_number', 'title' => Yii::t('pay', 'Notify Number'),"style"=>'width: 60px'],
            ['field' => 'notify_url', 'title' => Yii::t('pay', 'Notify Url'),"dataType"=>'url',"style"=>'width: 200px'],
            ['field' => 'return_url', 'title' => Yii::t('pay', 'Return Url'),"dataType"=>'url',"style"=>'width: 200px'],
            ['field' => 'status', 'title' => Yii::t('pay', 'Status'),"formatter"=>'status',"style"=>'width: 60px','statusList'=>['未支付','支付成功']],
            ['field' => 'created_at', 'title' => Yii::t('pay', 'Created At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('pay', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
        ];
    }

    public function getUser(){
       return $this->hasOne(WpUsers::class ,[ 'ID'=>'user_id' ]);
    }
}
