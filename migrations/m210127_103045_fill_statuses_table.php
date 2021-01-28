<?php

use yii\db\Migration;

/**
 * Class m210127_103045_fill_statuses_table
 */
class m210127_103045_fill_statuses_table extends Migration
{
    const TABLE = '{{%statuses}}';

    private $data = [
        'Open',
        'Needs offer',
        'Offered',
        'Approved',
        'In progress',
        'Ready',
        'Verified',
        'Closed',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            self::TABLE,
            ['title'],
            array_map(
                function ($item) {
                    return [$item];
                },
                $this->data
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->data as $title) {
            $this->delete(self::TABLE, ['title' => $title]);
        }
    }
}
