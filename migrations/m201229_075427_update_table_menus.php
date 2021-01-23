<?php

use yii\db\Migration;

class m201229_075427_update_table_menus extends Migration
{
    public function up()
    {
        $this->addColumn('{{%menus}}', 'icon', $this->string()->after('menu_name'));
        $this->addColumn('{{%menus}}', 'is_active', $this->smallInteger(1)->defaultValue('0')->after('route_url'));
        $this->addColumn('{{%menus}}', 'sort', $this->smallInteger(3)->defaultValue('0')->after('is_active'));
    }

    public function down()
    {
        $this->dropColumn('{{%menus}}', 'icon');
        $this->dropColumn('{{%menus}}', 'is_active');
        $this->dropColumn('{{%menus}}', 'sort');
    }
}
