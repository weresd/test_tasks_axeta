<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m210127_101502_create_files_table extends Migration
{
    const TABLE_OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    const TABLE = '{{%files}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull()->comment('File name'),
            'path' => $this->string(512)->notNull()->comment('File path'),
            'type' => $this->string(50)->comment('File type'),
        ], self::TABLE_OPTIONS);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
