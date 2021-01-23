<?php

use yii\db\Migration;

class m201222_181017_create_table_user_groups extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user_groups}}',
            [
                'id' => $this->primaryKey(10)->unsigned(),
                'name' => $this->string()->notNull(),
                'desc' => $this->string(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%user_groups}}');
    }
}
