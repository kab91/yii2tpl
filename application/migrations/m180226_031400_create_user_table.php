<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180226_031400_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'idstatus' => $this->smallInteger(6)->notNull()->defaultValue(10)->unsigned(),
            'idavatar' => $this->integer()->null()->unsigned(),
            'name' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(100)->null(),
            'password_reset_token' => $this->string(50)->null(),
            'email' => $this->string()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'identity' => $this->string()->null(),
            'site' => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
