<?php

use yii\db\Migration;

/**
 * Class m230430_121455_update_table_wp_express
 */
class m230430_121455_update_table_wp_express extends Migration
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
        echo "m230430_121455_update_table_wp_express cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        if ($this->tableExists('{{%express}}')) {
            $this->dropTable('{{%express}}');
        }

        $this->createTable('{{%express}}', [
            'id' => $this->primaryKey(),
            'send_user_id' => $this->integer(5)->notNull()->comment('发件人id'),
            'send_username' => $this->string(10)->defaultValue(null)->comment('发件人'),
            'send_phone' => $this->string(11)->defaultValue(null)->comment('发件人手机号'),
            'send_province' => $this->string()->defaultValue(null)->comment('发件省'),
            'send_city' => $this->string()->defaultValue(null)->comment('发件市'),
            'send_district' => $this->string()->defaultValue(null)->comment('发件区'),
            'send_address_info' => $this->string()->defaultValue(null)->comment('发件详细地址'),
            'send_number' => $this->integer(5)->notNull()->comment('发件数量'),
            'send_body' => $this->string()->notNull()->comment('发件列表'),

            'receiving_user_id' => $this->string(5)->notNull()->comment('收件人'),
            'receiving_username' => $this->string(10)->defaultValue(null)->comment('收件人'),
            'receiving_phone' => $this->string(11)->notNull()->comment('收件人手机号'),
            'receiving_province' => $this->string()->defaultValue(null)->comment('收件省'),
            'receiving_city' => $this->string()->defaultValue(null)->comment('收件市'),
            'receiving_district' => $this->string()->defaultValue(null)->comment('收件区'),
            'receiving_address_info' => $this->string()->defaultValue(null)->comment('收件详细地址'),
            'receiving_number' => $this->integer(5)->defaultValue(null)->comment('收件数量'),
            'receiving_body' => $this->string()->defaultValue(null)->comment('收件列表'),

            'express_pay_type' => $this->string()->defaultValue(null)->comment('快递费支付类型'),
            'express_pay_order' => $this->string()->defaultValue(null)->comment('支付单号'),
            'express_pay_status' => $this->string()->defaultValue(null)->comment('支付状态'),
            'express_pay_money' => $this->string()->defaultValue(null)->comment('支付金额'),

            'tracking_number' => $this->string()->defaultValue(null)->comment('快递单号'),

            'product_value' => $this->string()->defaultValue(null)->comment('商品价值'),
            'settlement_amount' => $this->string()->defaultValue(null)->comment('结算金额'),
            'status' => $this->string(2)->defaultValue(0)->comment('状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="快递"');
        $config = [
            0 => '下单成功',
            1 => '带支付快递费',
            2 => '发货成功,待收货',
            3 => '收货成功,待结算',
            4 => '结算成功',
            5 => '交易完成'
        ];


    }

    public function down()
    {
        $this->dropTable('{{%express}}');
        echo "m230430_121455_update_table_wp_express cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }

}
