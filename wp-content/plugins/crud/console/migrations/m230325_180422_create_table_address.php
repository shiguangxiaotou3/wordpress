<?php

use yii\db\Migration;

/**
 * Class m230325_180422_create_table_address
 */
class m230325_180422_create_table_address extends Migration
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
        echo "m230325_180422_create_table_address cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="地址表"';
        }

        if ($this->tableExists('{{%address}}')){
            $this->dropTable('{{%address}}');
        }
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(5)->defaultValue(null)->comment('用户id'),
            'username'=>$this->string(5)->defaultValue(null)->comment('姓名'),
            'phone'=>$this->string(11)->defaultValue(null)->comment('手机号'),
            'province'=>$this->string()->defaultValue(null)->comment('省'),
            'city'=>$this->string()->defaultValue(null)->comment('市'),
            'district'=>$this->string()->defaultValue(null)->comment('区'),
            'address_info'=>$this->string()->defaultValue(null)->comment('详细地址'),
            'address_type'=>$this->string(1)->defaultValue(0)->comment('收件/寄'),
            'status'=>$this->string(1)->defaultValue(0)->comment('是否默认'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%address}}');
        echo "m230325_180422_create_table_address cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }

}
