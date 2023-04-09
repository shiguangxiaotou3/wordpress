<?php

use yii\db\Migration;

/**
 * Class m230326_212746_create_table_money_log
 */
class m230326_212746_create_table_money_log extends Migration
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
        echo "m230326_212746_create_table_money_log cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
         $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="金额表"';
        }

        $this->createTable('{{%money}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(5)->defaultValue(null)->comment('用户id'),
            'money'=>$this->float(8,2)->defaultValue(null)->comment('金额'),
            'before'=>$this->float(8,2)->defaultValue(null)->comment('变更前'),
            'after'=>$this->float(8,2)->defaultValue(null)->comment('变更后'),
            'remarks'=>$this->string()->defaultValue(null)->comment('注释'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230326_212746_create_table_money_log cannot be reverted.\n";

        return false;
    }

}
