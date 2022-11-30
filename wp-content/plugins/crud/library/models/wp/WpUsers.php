<?php

namespace library\models\wp;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property int $user_status
 * @property string $display_name
 */
class WpUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_registered'], 'safe'],
            [['user_status'], 'integer'],
            [['user_login'], 'string', 'max' => 60],
            [['user_pass', 'user_activation_key'], 'string', 'max' => 255],
            [['user_nicename'], 'string', 'max' => 50],
            [['user_email', 'user_url'], 'string', 'max' => 100],
            [['display_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('wp', 'ID'),
            'user_login' => Yii::t('wp', 'User Login'),
            'user_pass' => Yii::t('wp', 'User Pass'),
            'user_nicename' => Yii::t('wp', 'User Nicename'),
            'user_email' => Yii::t('wp', 'User Email'),
            'user_url' => Yii::t('wp', 'User Url'),
            'user_registered' => Yii::t('wp', 'User Registered'),
            'user_activation_key' => Yii::t('wp', 'User Activation Key'),
            'user_status' => Yii::t('wp', 'User Status'),
            'display_name' => Yii::t('wp', 'Display Name'),
        ];
    }
}
