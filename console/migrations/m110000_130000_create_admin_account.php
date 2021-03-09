<?php

use yii\db\Migration;

class m110000_130000_create_admin_account extends Migration
{

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'email' => 'ltanh1194@gmail.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'updated_at' => time(),
            'created_at' => time()
        ]);

        $this->insert('{{%role}}', [
            'id' => 1,
            'name' => 'Administrator',
            'is_primary' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%user_role}}', [
            'user_id' => 1,
            'role_id' => 1
        ]);

    }

    public function down()
    {
        return TRUE;
    }
}
