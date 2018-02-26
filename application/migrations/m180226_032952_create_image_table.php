<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m180226_032952_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->null(),
            'author' => $this->string()->null(),
            'size' => $this->integer()->notNull(),
            'mimetype' => $this->string(20)->notNull(),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
