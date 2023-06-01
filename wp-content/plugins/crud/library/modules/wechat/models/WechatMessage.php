<?php

namespace crud\modules\wechat\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wp_wechat_message".
 *
 * @property int $id
 * @property string $to_user_name 接收人
 * @property string $from_username 发送人
 * @property string|null $msg_type 消息类型
 * @property string|null $event_type 事件类型
 * @property string|null $msg_info 事件类型
 * @property string|null $return_msg_info 事件类型
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 更新时间
 */
class WechatMessage extends ActiveRecord
{
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
        return 'wp_wechat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['to_user_name', 'from_username'], 'required'],
            [['msg_info', 'return_msg_info'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['to_user_name', 'from_username', 'msg_type', 'event_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wechat', 'ID'),
            'to_user_name' => Yii::t('wechat', 'To User Name'),
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
            ['field' =>'to_user_name', 'title' => Yii::t('wechat', 'To User Name'),"style"=>'width: 130px'],
            ['field' =>'from_username' , 'title' =>Yii::t('wechat', 'From Username'),"style"=>'width: 130px'],
            ['field' =>'msg_type', 'title' => Yii::t('wechat', 'Msg Type'),"style"=>'width: 60px'],
            ['field' =>'event_type', 'title' => Yii::t('wechat', 'Event Type'),"style"=>'width: 60px'],
            [
                'field' =>'msg_info',
                'title' =>Yii::t('wechat', 'Msg Info'),
                'dataType'=>'json',
                "style"=>'width: 60px'
            ],
            [
                'field' =>'return_msg_info' ,
                'title' => Yii::t('wechat', 'Return Msg Info'),
                'dataType'=>'json',
                "style"=>'width: 60px'
            ],
            [
                'field' => 'created_at',
                'title' => Yii::t('pay', 'Created At'),
                "dataType"=>'timeStamp',
                "style"=>'width: 110px'
            ],
            [
                'field' => 'updated_at',
                'title' => Yii::t('pay', 'Updated At'),
                "dataType"=>'timeStamp',
                "style"=>'width: 110px'
            ],
        ];
    }
}
