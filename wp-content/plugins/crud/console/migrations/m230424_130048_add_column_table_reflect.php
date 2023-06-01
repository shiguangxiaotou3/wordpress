<?php

use yii\db\Migration;

/**
 * Class m230424_130048_add_column_table_reflect
 */
class m230424_130048_add_column_table_reflect extends Migration
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
        echo "m230424_130048_add_column_table_reflect cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%pay_reflect}}',
            'pay_type',
            $this->string()->defaultValue(null)->comment('提现渠道')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('{{%pay_reflect}}','pay_type');
        echo "m230424_130048_add_column_table_reflect cannot be reverted.\n";

        return false;
    }

    
    
    


}
