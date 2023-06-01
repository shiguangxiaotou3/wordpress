<?php

namespace crud\modules\market\models;

use Yii;
/**
 * This is the model class for table "wp_express".
 *
 * @property int $id
 * @property int $send_user_id 发件人id
 * @property string|null $send_username 发件人
 * @property string|null $send_phone 发件人手机号
 * @property string|null $send_province 发件省
 * @property string|null $send_city 发件市
 * @property string|null $send_district 发件区
 * @property string|null $send_address_info 发件详细地址
 * @property int $send_number 发件数量
 * @property string $send_body 发件列表
 * @property string $receiving_user_id 收件人
 * @property string|null $receiving_username 收件人
 * @property string $receiving_phone 收件人手机号
 * @property string|null $receiving_province 收件省
 * @property string|null $receiving_city 收件市
 * @property string|null $receiving_district 收件区
 * @property string|null $receiving_address_info 收件详细地址
 * @property int|null $receiving_number 收件数量
 * @property string|null $receiving_body 收件列表
 * @property string|null $express_pay_type 快递费支付类型
 * @property string|null $express_pay_order 支付单号
 * @property string|null $express_pay_status 支付状态
 * @property string|null $express_pay_money 支付金额
 * @property string|null $tracking_number 快递单号
 * @property string|null $product_value 商品价值
 * @property string|null $settlement_amount 结算金额
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
            [['send_user_id', 'send_number', 'send_body', 'receiving_user_id', 'receiving_phone'], 'required'],
            [['send_user_id', 'send_number', 'receiving_number', 'created_at', 'updated_at'], 'integer'],
            [['send_username', 'receiving_username'], 'string', 'max' => 10],
            [['send_phone', 'receiving_phone'], 'string', 'max' => 11],
            [['send_province', 'send_city', 'send_district', 'send_address_info', 'send_body', 'receiving_province', 'receiving_city', 'receiving_district', 'receiving_address_info', 'receiving_body', 'express_pay_type', 'express_pay_order', 'express_pay_status', 'express_pay_money', 'tracking_number', 'product_value', 'settlement_amount'], 'string', 'max' => 255],
            [['receiving_user_id'], 'string', 'max' => 5],
            [['status'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('market', 'ID'),
            'send_user_id' => Yii::t('market', 'Send User ID'),
            'send_username' => Yii::t('market', 'Send Username'),
            'send_phone' => Yii::t('market', 'Send Phone'),
            'send_province' => Yii::t('market', 'Send Province'),
            'send_city' => Yii::t('market', 'Send City'),
            'send_district' => Yii::t('market', 'Send District'),
            'send_address_info' => Yii::t('market', 'Send Address Info'),
            'send_number' => Yii::t('market', 'Send Number'),
            'send_body' => Yii::t('market', 'Send Body'),
            'receiving_user_id' => Yii::t('market', 'Receiving User ID'),
            'receiving_username' => Yii::t('market', 'Receiving Username'),
            'receiving_phone' => Yii::t('market', 'Receiving Phone'),
            'receiving_province' => Yii::t('market', 'Receiving Province'),
            'receiving_city' => Yii::t('market', 'Receiving City'),
            'receiving_district' => Yii::t('market', 'Receiving District'),
            'receiving_address_info' => Yii::t('market', 'Receiving Address Info'),
            'receiving_number' => Yii::t('market', 'Receiving Number'),
            'receiving_body' => Yii::t('market', 'Receiving Body'),
            'express_pay_type' => Yii::t('market', 'Express Pay Type'),
            'express_pay_order' => Yii::t('market', 'Express Pay Order'),
            'express_pay_status' => Yii::t('market', 'Express Pay Status'),
            'express_pay_money' => Yii::t('market', 'Express Pay Money'),
            'tracking_number' => Yii::t('market', 'Tracking Number'),
            'product_value' => Yii::t('market', 'Product Value'),
            'settlement_amount' => Yii::t('market', 'Settlement Amount'),
            'status' => Yii::t('market', 'Status'),
            'created_at' => Yii::t('market', 'Created At'),
            'updated_at' => Yii::t('market', 'Updated At'),
        ];
    }

    public function columns(){
        $js=<<<JS
    (row,field)=>{
        return `<b>\${row.send_username} \${row.send_phone}</b><br>
    \${row.send_province}\${row.send_city}\${row.send_district}`;
    }
JS;
        $js1 =<<<JS
    (row,field)=>{
        return `<b>\${row.receiving_username} \${row.receiving_phone}</b><br>
    \${row.receiving_province}\${row.receiving_city}\${row.receiving_district}`;
    }
JS;
        return [
            ['field' => 'id' ,'title' => Yii::t('market', 'ID')],
//            ['field' =>'send_user' ,'title' => '收件人','dataType'=>'custom','callBack'=>$js],
//            ['field' =>'send_user_id' ,'title' => Yii::t('market', 'Send User ID')],
            ['field' =>'send_username' ,'title' => Yii::t('market', 'Send Username')],
            ['field' =>'send_phone' ,'title' => Yii::t('market', 'Send Phone')],
            ['field' =>'send_province'  ,'title'=> Yii::t('market', 'Send Province')],
            ['field' =>'send_city' ,'title' => Yii::t('market', 'Send City')],
            ['field' =>'send_district'  ,'title'=> Yii::t('market', 'Send District')],
//            ['field' =>'send_address_info'  ,'title'=> Yii::t('market', 'Send Address Info')],
            ['field' =>'send_number' ,'title' => Yii::t('market', 'Send Number')],
            ['field' =>'send_body'  ,'title'=> Yii::t('market', 'Send Body'), 'dataType'=>'json',
                ],
//            ['field' =>'receiving_user_id'  ,'title'=> Yii::t('market', 'Receiving User ID')],
//            ['field' =>'receiving_user' ,'title' => '收件人','dataType'=>'custom','callBack'=>$js],
            ['field' =>'receiving_username'  ,'title'=> Yii::t('market', 'Receiving Username')],
            ['field' =>'receiving_phone' ,'title' => Yii::t('market', 'Receiving Phone')],
            ['field' =>'receiving_province'  ,'title'=> Yii::t('market', 'Receiving Province')],
            ['field' =>'receiving_city'  ,'title'=> Yii::t('market', 'Receiving City')],
            ['field' =>'receiving_district'  ,'title'=> Yii::t('market', 'Receiving District')],
//            ['field' =>'receiving_address_info'  ,'title'=> Yii::t('market', 'Receiving Address Info')],
            ['field' =>'receiving_number'  ,'title'=> Yii::t('market', 'Receiving Number')],
            ['field' =>'receiving_body'  ,'title'=> Yii::t('market', 'Receiving Body'), 'dataType'=>'json',
                ],
            ['field' =>'express_pay_type'  ,'title'=> Yii::t('market', 'Express Pay Type')],
            ['field' =>'express_pay_order'  ,'title'=> Yii::t('market', 'Express Pay Order')],
            ['field' =>'express_pay_status'  ,'title'=> Yii::t('market', 'Express Pay Status')],
            ['field' =>'express_pay_money'  ,'title'=> Yii::t('market', 'Express Pay Money')],
            ['field' =>'tracking_number'  ,'title'=> Yii::t('market', 'Tracking Number')],
            ['field' => 'product_value'  ,'title'=> Yii::t('market', 'Product Value')],
            ['field' =>'settlement_amount'  ,'title'=> Yii::t('market', 'Settlement Amount')],
            ['field' => 'status', 'title' => Yii::t('market', 'Status'),"formatter"=>'status','statusList'=>[
                0 => '下单成功',
                1 => '待支付快递费',
                2 => '发货成功,待收货',
                3 => '收货成功,待结算',
                4 => '结算成功',
                5 => '交易完成']],
//            ['field' => 'created_at', 'title' => Yii::t('market', 'Created At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
//            ['field' => 'updated_at', 'title' => Yii::t('market', 'Updated At'),"dataType"=>'timeStamp',"style"=>'width: 130px'],
        ];
    }
}
