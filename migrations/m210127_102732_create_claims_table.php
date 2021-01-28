<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%claims}}`.
 */
class m210127_102732_create_claims_table extends Migration
{
    const TABLE_OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    const TABLE = '{{%claims}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(64)->notNull()->comment('Claim name'),
            'file_id' => $this->integer()->comment('Claim image'),
            'description' => $this->text()->comment('Claim desc'),
            'end_date' => $this->dateTime()->comment('Claim date end'),
            'status_id' => $this->integer()->comment('Claim status'),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], self::TABLE_OPTIONS);

        $this->addForeignKey(
            'claim_status_id_fk',
            self::TABLE,
            'status_id',
            '{{%statuses}}',
            'id'
        );

        $this->addForeignKey(
            'claim_file_id_fk',
            self::TABLE,
            'file_id',
            '{{%files}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('claim_status_id_fk', self::TABLE);
        $this->dropForeignKey('claim_file_id_fk', self::TABLE);
        $this->dropTable(self::TABLE);
    }
}
