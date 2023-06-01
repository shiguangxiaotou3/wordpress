<?php

use yii\db\Migration;

/**
 * Class m230507_064028_create_table_movie
 */
class m230507_064028_create_table_movie extends Migration
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
        echo "m230507_064028_create_table_movie cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        if($this->tableExists('{{%movie}}')){
            $this->dropTable('{{%movie}}');
        }
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="电影表"';
        }
        $this->createTable('{{%movie}}', [
            'id' => $this->primaryKey(),
            'movie_name'=>$this->string()->notNull()->comment('片名'),
            'translated_name'=>$this->string()->defaultValue(null)->comment('译名'),
            'country'=>$this->string()->defaultValue(null)->comment('国家'),
            'category'=>$this->string()->defaultValue(null)->comment('类别'),
            'keywords'=>$this->string()->comment(null)->comment('关键字'),
            'release_date'=>$this->string()->defaultValue(null)->comment('上映日期'),
            'img'=>$this->string()->defaultValue(null)->comment('海报'),
            'bt'=>$this->string()->defaultValue(null)->comment('链接'),
            'director'=>$this->string()->defaultValue(null)->comment('导演'),
            'describe'=>$this->string()->defaultValue(null)->comment('简介'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%movie}}');
        echo "m230507_064028_create_table_movie cannot be reverted.\n";

        return false;
    }
    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }
}
