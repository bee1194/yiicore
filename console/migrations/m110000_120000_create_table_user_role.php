<?php

use yii\db\Migration;

class m110000_120000_create_table_user_role extends Migration
{

    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_role}}', [
            'user_id' => $this->integer()->notNull(),
            'role_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('PRIMARY_KEY', '{{%user_role}}', ['user_id', 'role_id']);

        $this->addForeignKey('fk_map_user', '{{%user_role}}', 'user_id', '{{%user}}',
            'id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('fk_map_user_role', '{{%user_role}}', 'role_id',
            '{{%role}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropForeignKey('fk_map_user_role', '{{%user_role}}');
        $this->dropForeignKey('fk_map_user', '{{%user_role}}');
        $this->dropTable('{{%user_role}}');
    }
}
