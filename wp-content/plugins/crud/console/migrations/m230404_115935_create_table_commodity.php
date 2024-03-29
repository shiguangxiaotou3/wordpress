<?php

use yii\db\Migration;

/**
 * Class m230404_115935_create_table_commodity
 */
class m230404_115935_create_table_commodity extends Migration
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
        echo "m230404_115935_create_table_commodity cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="商品表"';
        }
        if($this->tableExists('{{%categorize}}')){
            $this->dropTable('{{%categorize}}');
        }
        if($this->tableExists('{{%categorize_price}}')){
            $this->dropTable('{{%categorize_price}}');
        }
        if($this->tableExists('{{%storehouse}}')){
            $this->dropTable('{{%storehouse}}');
        }
        if($this->tableExists('{{%express}}')){
            $this->dropTable('{{%express}}');
        }

        $this->createTable('{{%categorize}}', [
            'id' => $this->primaryKey(),
            'categorize_id'=>$this->integer(5)->defaultValue(null)->comment('分类id'),
            'categorize_name'=>$this->string()->defaultValue(null)->comment('名称'),
            'categorize_type'=>$this->string()->defaultValue(null)->comment('型号'),
            'categorize_color'=>$this->integer(5)->defaultValue(null)->comment('颜色'),
            'categorize_storage'=>$this->string()->defaultValue(null)->comment('存储大小'),
            'categorize_describe'=>$this->string()->defaultValue(null)->comment('描述'),
            'categorize_image'=>$this->string()->defaultValue(null)->comment('图片'),
            'categorize_keyword'=>$this->string()->defaultValue(null)->comment('关键词'),
            'remarks'=>$this->string()->defaultValue(null)->comment('备注'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);

        $this->createTable('{{%categorize_price}}', [
            'id' => $this->primaryKey(),
            'commodity_id'=>$this->integer(5)->defaultValue(null)->comment('商品id'),
            'publish_id'=>$this->integer(5)->defaultValue(null)->comment('发布人'),
            'publish_time'=>$this->integer(5)->defaultValue(null)->comment('发布时间'),
            'publish_price'=>$this->integer(5)->defaultValue(null)->comment('发布时间'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="商品价格"');

        $this->createTable('{{%storehouse}}', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(5)->defaultValue(null)->comment('发件人'),
            'phone'=>$this->string(11)->defaultValue(null)->comment('手机号'),
            'province'=>$this->string()->defaultValue(null)->comment('省'),
            'city'=>$this->string()->defaultValue(null)->comment('市'),
            'district'=>$this->string()->defaultValue(null)->comment('区'),
            'address_info'=>$this->string()->defaultValue(null)->comment('详细地址'),
            'status'=>$this->string(1)->defaultValue(0)->comment('是否默认'),

            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="仓库表"');

        $this->createTable('{{%express}}', [
            'id' => $this->primaryKey(),
            'send_username'=>$this->string(5)->defaultValue(null)->comment('发件人'),
            'send_phone'=>$this->string(11)->defaultValue(null)->comment('发件人手机号'),
            'send_province'=>$this->string()->defaultValue(null)->comment('发件人省'),
            'send_city'=>$this->string()->defaultValue(null)->comment('发件人市'),
            'send_district'=>$this->string()->defaultValue(null)->comment('发件人区'),
            'send_address_info'=>$this->string()->defaultValue(null)->comment('发详细地址'),

            'receiving_username'=>$this->string(5)->defaultValue(null)->comment('收件人'),
            'receiving_phone'=>$this->string(11)->defaultValue(null)->comment('收件人手机号'),
            'receiving_province'=>$this->string()->defaultValue(null)->comment('收件人省'),
            'receiving_city'=>$this->string()->defaultValue(null)->comment('收件人市'),
            'receiving_district'=>$this->string()->defaultValue(null)->comment('收件人区'),
            'receiving_address_info'=>$this->string()->defaultValue(null)->comment('收详细地址'),

            'status'=>$this->string(1)->defaultValue(0)->comment('状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="快递"');
    }

    public function down()
    {
        $this->dropTable('{{%categorize}}');
        $this->dropTable('{{%categorize_price}}');
        $this->dropTable('{{%storehouse}}');
        $this->dropTable('{{%express}}');
        echo "m230404_115935_create_table_commodity cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }


}
