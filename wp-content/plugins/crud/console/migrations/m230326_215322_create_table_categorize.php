<?php

use yii\db\Migration;

/**
 * Class m230326_215322_create_table_categorize
 */
class m230326_215322_create_table_categorize extends Migration
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
        echo "m230326_215322_create_table_categorize cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="分类表"';
        }

        $this->createTable('{{%categorize}}', [
            'id' => $this->primaryKey(),
            'categorize_id'=>$this->integer(5)->defaultValue(null)->comment('分类id'),
            'parent_id'=>$this->integer(5)->defaultValue(0)->comment('父类id'),
            'categorize_name'=>$this->string()->defaultValue(null)->comment('名称'),
            'remarks'=>$this->string()->defaultValue(null)->comment('备注'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m230326_215322_create_table_categorize cannot be reverted.\n";

        return false;
    }

}
