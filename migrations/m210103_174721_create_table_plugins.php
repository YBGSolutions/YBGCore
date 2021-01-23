<?php

use yii\db\Migration;

class m210103_174721_create_table_plugins extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%plugins}}',
            [
                'id' => $this->primaryKey(10)->unsigned(),
                'plugin_name' => $this->string()->notNull(),
                'desc' => $this->text(),
                'author' => $this->string(),
                'state' => $this->smallInteger(1)->defaultValue('0'),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%plugins}}');
    }
}
