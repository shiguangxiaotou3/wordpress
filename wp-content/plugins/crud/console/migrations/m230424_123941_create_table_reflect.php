<?php

use yii\db\Migration;

/**
 * Class m230424_123941_create_table_reflect
 */
class m230424_123941_create_table_reflect extends Migration
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
        echo "m230424_123941_create_table_reflect cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        if($this->tableExists('{{%pay_reflect}}')){
            $this->dropTable('{{%pay_reflect}}');
        }
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="提现申请"';
        }

        $this->createTable('{{%pay_reflect}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull()->comment(''),
            'account'=>$this->string()->notNull()->comment('收款账号'),
            'account_name'=>$this->string()->notNull()->comment('用户名'),
            'money'=>$this->string()->notNull()->comment('金额'),
            'title'=>$this->string()->defaultValue(null)->comment('标题'),
            'action_id'=>$this->integer()->defaultValue(null)->comment('操作者'),
            'status'=>$this->integer()->defaultValue(0)->comment('提现状态'),
            'remark'=>$this->string()->defaultValue(null)->comment('备注'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%pay_reflect}}');
        echo "m230424_123941_create_table_reflect cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }


}
