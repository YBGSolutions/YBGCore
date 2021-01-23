<?php

use yii\db\Migration;

class m201217_190613_create_table_menus extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menus}}',
            [
                'id' => $this->smallInteger(5)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'menu_name' => $this->string()->notNull()->defaultValue(''),
                'parent_id' => $this->smallInteger()->notNull()->defaultValue('0')->comment('0: Root'),
                'route_url' => $this->string()->notNull(),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%menus}}');
    }
}
