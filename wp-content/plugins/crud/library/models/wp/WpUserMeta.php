<?php

namespace crud\models\wp;

use Yii;
/**
 * This is the model class for table "wp_usermeta".
 *
 * @property int $umeta_id
 * @property int $user_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 */
class WpUserMeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_usermeta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'umeta_id' => 'Umeta ID',
            'user_id' => 'User ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function columns()
    {
        return [
            ['field' =>'umeta_id', 'title' => 'Umeta ID'],
            ['field' =>'user_id', 'title' => 'User ID'],
            ['field' =>'meta_key', 'title' => 'Meta Key'],
            ['field' =>'meta_value', 'title' => 'Meta Value'],
        ];
    }

    //'Umeta ID' => '',
    //'User ID' => '',
    //'Meta Key' => '',
    //'Meta Value' => '',
}
