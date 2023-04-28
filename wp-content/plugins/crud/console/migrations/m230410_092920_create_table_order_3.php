<?php

use yii\db\Migration;

/**
 * Class m230410_092920_create_table_order_3
 */
class m230410_092920_create_table_order_3 extends Migration
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
        echo "m230410_092920_create_table_order_3 cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
         $this->dropTable('{{%order}}');
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="订单表"';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'pal_type'=>$this->string(15)->notNull()->comment('支付场景'),
            'user_id'=>$this->integer(5)->defaultValue(null)->comment('支付场景'),
            'order_id'=>$this->string(255)->notNull()->comment('订单id'),
            'subject'=>$this->string(255)->defaultValue(null)->comment('标题'),
            'total_amount'=>$this->decimal(8,2)->notNull()->comment('订单金额'),
            'receipt_amount'=>$this->decimal(8,2)->defaultValue(null)->comment('实收金额'),
            "trade_no"=>$this->string(255)->defaultValue(null)->comment('支付流水号'),
            'notify_number'=>$this->string(255)->defaultValue(null)->comment('通知次数'),
            'notify_url'=>$this->string(255)->notNull()->comment('异步通知url'),
            'return_url'=>$this->string(255)->defaultValue(null)->comment('同步跳转url'),
            'status'=>$this->string()->defaultValue(0)->comment('支付状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230410_092920_create_table_order_3 cannot be reverted.\n";

        return false;
    }

}
