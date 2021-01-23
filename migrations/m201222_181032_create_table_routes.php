<?php

use yii\db\Migration;

class m201222_181032_create_table_routes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%routes}}',
            [
                'id' => $this->primaryKey(10)->unsigned(),
                'route_url' => $this->string()->notNull(),
                'is_active' => $this->smallInteger(1)->notNull()->defaultValue('0')->comment('0: disable, 1:enable'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%routes}}');
    }
}
