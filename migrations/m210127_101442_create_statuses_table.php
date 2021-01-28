<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%statuses}}`.
 */
class m210127_101442_create_statuses_table extends Migration
{
    const TABLE = '{{%statuses}}';
    const TABLE_OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull()->comment('Status name'),
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
