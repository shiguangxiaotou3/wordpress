<?php

use yii\db\Migration;

/**
 * Class m230523_150039_create_table_imessage_3
 */
class m230523_150039_create_table_imessage_3 extends Migration
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
        echo "m230523_150039_create_table_imessage_3 cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="微信公众号消息"';
        }
        if($this->tableExists('{{%imessage}}')){
            $this->dropTable('{{%imessage}}');
        }
        $this->createTable('{{%imessage}}', [
            'id' => $this->primaryKey(),
            'phone'=>$this->string()->notNull()->unique()->comment('手机号'),
            'message'=>$this->text()->defaultValue(null)->comment('消息'),
            'status'=>$this->integer()->defaultValue(0)->comment('支付状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230523_150039_create_table_imessage_3 cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }

}
