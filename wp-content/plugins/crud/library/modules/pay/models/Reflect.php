<?php

namespace crud\modules\pay\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "wp_pay_reflect".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $pay_type 提现渠道
 * @property string $account 收款账号
 * @property string $account_name 用户名
 * @property float $money 金额
 * @property string|null $title 标题
 * @property int|null $action_id 操作者
 * @property int|null $status 提现状态
 * @property string|null $remark 备注
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class Reflect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_pay_reflect';
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    # 修改之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
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
            [['user_id', 'account', 'account_name', 'money'], 'required'],
            [['user_id', 'action_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['money'], 'number'],
            [['pay_type', 'account', 'account_name', 'title', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pay', 'ID'),
            'user_id' => Yii::t('pay', 'User ID'),
            'pay_type' => Yii::t('pay', 'Pay Type'),
            'account' => Yii::t('pay', 'Account'),
            'account_name' => Yii::t('pay', 'Account Name'),
            'money' => Yii::t('pay', 'Money'),
            'title' => Yii::t('pay', 'Title'),
            'action_id' => Yii::t('pay', 'Action ID'),
            'status' => Yii::t('pay', 'Status'),
            'remark' => Yii::t('pay', 'Remark'),
            'created_at' => Yii::t('pay', 'Created At'),
            'updated_at' => Yii::t('pay', 'Updated At'),
        ];
    }

    public function columns()
    {
        return [
            ['field' => 'id', 'title' => Yii::t('pay', 'ID'), "style" => 'width: 20px'],
            ['field' => 'user_id', 'title' => Yii::t('pay', 'User ID'),"style" => 'width: 50px'],
            ['field' => 'pay_type', 'title' => Yii::t('pay', 'Pay Type'),"style" => 'width: 80px'],
            ['field' => 'account', 'title' => Yii::t('pay', 'Account'),"style" => 'width: 130px'],
            ['field' => 'account_name', 'title' => Yii::t('pay', 'Account Name'),"style" => 'width: 130px'],
            ['field' => 'money', 'title' => Yii::t('pay', 'Money'),"style" => 'width: 60px'],
            ['field' => 'title', 'title' => Yii::t('pay', 'Title'),"style" => 'width: 130px'],
            ['field' => 'action_id', 'title' => Yii::t('pay', 'Action ID'),"style" => 'width: 80px'],
            [
                'field' => 'status',
                'title' => Yii::t('pay', 'Status'),
                "formatter" => 'status',
                "style" => 'width: 60px',
                'statusList' => ['未支付', '支付成功']
            ],
            ['field' => 'remark', 'title' => Yii::t('pay', 'Remark'),"style" => 'width: 130px'],
            [
                'field' => 'created_at',
                'title' => Yii::t('pay', 'Created At'),
                "dataType" => 'timeStamp',
                "style" => 'width: 130px'
            ],
            [
                'field' => 'updated_at',
                'title' => Yii::t('pay', 'Updated At'),
                "dataType" => 'timeStamp',
                "style" => 'width: 130px'
            ],
            [
                'field' => 'operate',
                'title' => Yii::t('pay', 'Actions'),
                'buttons'=>[
                    [
                        'name'=>'agree',
                        'text'=>'同意',
                        'class'=>'button',
                        'callBack'=>''
                    ],
                    [
                        'name'=>'reject',
                        'text'=>'编辑',
                        'class'=>'button',
                        'callBack'=>''
                    ],
                ]
            ]
        ];
    }
}
