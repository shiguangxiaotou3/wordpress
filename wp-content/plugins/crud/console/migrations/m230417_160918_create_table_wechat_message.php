<?php

use yii\db\Migration;

/**
 * Class m230417_160918_create_table_wechat_message
 */
class m230417_160918_create_table_wechat_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230417_160918_create_table_wechat_message cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="微信公众号消息"';
        }

        $this->createTable('{{%wechat_message}}', [
            'id' => $this->primaryKey(),
            'to_userName'=>$this->string()->notNull()->comment(''),
            'from_username'=>$this->string()->notNull()->comment('支付场景'),
            'msg_type'=>$this->string()->defaultValue(null)->comment('消息类型'),
            'event_type'=>$this->string()->defaultValue(null)->comment('事件类型'),
            'msg_info'=>$this->string()->defaultValue(null)->comment('事件类型'),
            'return_msg_info'=>$this->string()->defaultValue(null)->comment('事件类型'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230417_160918_create_table_wechat_message cannot be reverted.\n";

        return false;
    }

}
