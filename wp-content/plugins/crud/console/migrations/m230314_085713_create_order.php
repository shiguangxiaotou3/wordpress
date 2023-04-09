<?php

use yii\db\Migration;

/**
 * Class m230314_085713_create_order
 */
class m230314_085713_create_order extends Migration
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
        echo "m230314_085713_create_order cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="订单表"';
        }
        //$palType , $orderId, $subject, $money, $notifyUrl='', $returnUrl=''
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'palType'=>$this->string(10)->notNull()->comment('支付场景'),
            'user_id'=>$this->integer(5)->notNull()->comment('支付场景'),
            'orderId'=>$this->string(255)->notNull()->comment('订单id'),
            'subject'=>$this->string(255)->notNull()->comment('标题'),
            'money'=>$this->float()->notNull()->comment('金额'),
            "trade_no"=>$this->string(255)->notNull()->comment('支付流水号'),
            'notifyUrl'=>$this->string(255)->notNull()->comment('异步通知url'),
            'returnUrl'=>$this->string(255)->notNull()->comment('同步跳转url'),
            'status'=>$this->string()->defaultValue(0)->comment('支付状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230314_085713_create_order cannot be reverted.\n";

        return false;
    }

}
