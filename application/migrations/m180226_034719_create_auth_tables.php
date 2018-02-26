<?php

use yii\db\Schema;
use yii\db\Migration;

class m180226_034719_create_auth_tables extends Migration
{
    public function safeUp()
    {
        // auth_rule table
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('name', '{{%auth_rule}}', 'name');

        // auth_item table
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64)->null(),
            'data' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('name', '{{%auth_item}}', 'name');
        $this->createIndex('type', '{{%auth_item}}', 'type');
        $this->createIndex('rule_name', '{{%auth_item}}', ['rule_name']);
        $this->addForeignKey('rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'SET NULL', 'CASCADE');

        // auth_item_child table
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ]);
        $this->addPrimaryKey('parent-child', '{{%auth_item_child}}', ['parent', 'child']);
        $this->addForeignKey('auth_item_child_ibfk_1', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_ibfk_2', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        // auth_assignment table
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addPrimaryKey('item_name-user_id', '{{%auth_assignment}}', ['item_name', 'user_id']);
        $this->addForeignKey('auth_assignment_ibfk_1', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        // add roles
        $this->batchInsert('{{%auth_item}}',
            ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'],
            [
                ['admin', 2, NULL, NULL, NULL, 0, 0],
                ['user', 2, NULL, NULL, NULL, 0, 0],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{@auth_rule}}');
    }
}
