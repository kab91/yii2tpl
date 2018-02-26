<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180226_033432_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'level' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
        ]);

        $this->createIndex('lft', '{{%category}}', ['lft']);
        $this->createIndex('rgt', '{{%category}}', ['rgt']);
        $this->createIndex('level', '{{%category}}', ['level']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
