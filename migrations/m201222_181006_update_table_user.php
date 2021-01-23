<?php

use yii\db\Migration;

class m201222_181006_update_table_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'group_id', $this->smallInteger()->notNull()->defaultValue('-1')->after('status'));

        $this->alterColumn('{{%user}}', 'email', $this->string());
        $this->alterColumn('{{%user}}', 'created_at', $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('{{%user}}', 'updated_at', $this->timestamp());
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'created_at', $this->integer()->notNull());
        $this->alterColumn('{{%user}}', 'updated_at', $this->integer()->notNull());

        $this->dropColumn('{{%user}}', 'group_id');
    }
}
