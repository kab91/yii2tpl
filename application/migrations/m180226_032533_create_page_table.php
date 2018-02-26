<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m180226_032533_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey()->unsigned(),
            'slug' => $this->string()->unique()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'seo_keywords' => $this->string()->null(),
            'seo_description' => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
