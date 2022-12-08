<?php

namespace library\models\wp;

use Yii;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $comment_ID
 * @property int $comment_post_ID
 * @property string $comment_author
 * @property string $comment_author_email
 * @property string $comment_author_url
 * @property string $comment_author_IP
 * @property string $comment_date
 * @property string $comment_date_gmt
 * @property string $comment_content
 * @property int $comment_karma
 * @property string $comment_approved
 * @property string $comment_agent
 * @property string $comment_type
 * @property int $comment_parent
 * @property int $user_id
 */
class WpComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_post_ID', 'comment_karma', 'comment_parent', 'user_id'], 'integer'],
            [['comment_author', 'comment_content'], 'required'],
            [['comment_author', 'comment_content'], 'string'],
            [['comment_date', 'comment_date_gmt'], 'safe'],
            [['comment_author_email', 'comment_author_IP'], 'string', 'max' => 100],
            [['comment_author_url'], 'string', 'max' => 200],
            [['comment_approved', 'comment_type'], 'string', 'max' => 20],
            [['comment_agent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment_ID' => Yii::t('wp', 'Comment ID'),
            'comment_post_ID' => Yii::t('wp', 'Comment Post ID'),
            'comment_author' => Yii::t('wp', 'Comment Author'),
            'comment_author_email' => Yii::t('wp', 'Comment Author Email'),
            'comment_author_url' => Yii::t('wp', 'Comment Author Url'),
            'comment_author_IP' => Yii::t('wp', 'Comment Author Ip'),
            'comment_date' => Yii::t('wp', 'Comment Date'),
            'comment_date_gmt' => Yii::t('wp', 'Comment Date Gmt'),
            'comment_content' => Yii::t('wp', 'Comment Content'),
            'comment_karma' => Yii::t('wp', 'Comment Karma'),
            'comment_approved' => Yii::t('wp', 'Comment Approved'),
            'comment_agent' => Yii::t('wp', 'Comment Agent'),
            'comment_type' => Yii::t('wp', 'Comment Type'),
            'comment_parent' => Yii::t('wp', 'Comment Parent'),
            'user_id' => Yii::t('wp', 'User ID'),
        ];
    }
}
