<?php

namespace crud\modules\wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wp_wechat_message".
 *
 * @property int $id
 * @property string $to_userName
 * @property string $from_username 支付场景
 * @property string|null $msg_type 消息类型
 * @property string|null $event_type 事件类型
 * @property string|null $msg_info 事件类型
 * @property string|null $return_msg_info 事件类型
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class WechatMessage extends ActiveRecord
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
        return 'wp_wechat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['to_userName', 'from_username'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['to_userName', 'from_username', 'msg_type', 'event_type', 'msg_info', 'return_msg_info'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wechat', 'ID'),
            'to_userName' => Yii::t('wechat', 'To User Name'),
            'from_username' => Yii::t('wechat', 'From Username'),
            'msg_type' => Yii::t('wechat', 'Msg Type'),
            'event_type' => Yii::t('wechat', 'Event Type'),
            'msg_info' => Yii::t('wechat', 'Msg Info'),
            'return_msg_info' => Yii::t('wechat', 'Return Msg Info'),
            'created_at' => Yii::t('wechat', 'Created At'),
            'updated_at' => Yii::t('wechat', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function columns()
    {
        return [
            ['field' => 'id', 'title' => Yii::t('pay', 'ID'),"style"=>'width: 20px'],
            ['field' =>'to_userName', 'title' => Yii::t('wechat', 'To User Name'),"style"=>'width: 100px'],
            ['field' =>'from_username' , 'title' =>Yii::t('wechat', 'From Username'),"style"=>'width: 100px'],
            ['field' =>'msg_type', 'title' => Yii::t('wechat', 'Msg Type'),"style"=>'width: 80px'],
            ['field' =>'event_type', 'title' => Yii::t('wechat', 'Event Type'),"style"=>'width: 80px'],
            ['field' =>'msg_info', 'title' =>Yii::t('wechat', 'Msg Info'),"style"=>'width: 130px'],
            ['field' =>'return_msg_info' , 'title' => Yii::t('wechat', 'Return Msg Info'),"style"=>'width: 130px'],
            ['field' => 'created_at', 'title' => Yii::t('pay', 'Created At'),"formatter"=>'datetime',"style"=>'width: 130px'],
            ['field' => 'updated_at', 'title' => Yii::t('pay', 'Updated At'),"formatter"=>'datetime',"style"=>'width: 130px'],
        ];
    }
}
