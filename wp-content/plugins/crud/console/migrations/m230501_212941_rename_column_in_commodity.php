<?php

use yii\db\Migration;

/**
 * Class m230501_212941_rename_column_in_commodity
 */
class m230501_212941_rename_column_in_commodity extends Migration
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
        echo "m230501_212941_rename_column_in_commodity cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->renameColumn('{{%commodity}}', 'commodity_image', 'commodity_image');
    }

    public function down()
    {
        $this->renameColumn('{{%commodity}}', 'commodity_image','commodity_image');
        echo "m230501_212941_rename_column_in_commodity cannot be reverted.\n";

        return false;
    }

    public function tableExists($tableName){
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema !== null);
    }


}
