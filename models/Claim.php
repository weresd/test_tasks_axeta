<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "claims".
 *
 * @property int $id
 * @property string $title
 * @property int|null $file_id
 * @property string|null $description
 * @property string|null $end_date
 * @property int|null $status_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property File $file
 * @property Status $status
 */
class Claim extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claims';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['file_id', 'status_id'], 'integer'],
            [['description'], 'string'],
            [['end_date', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'file_id' => Yii::t('app', 'Img'),
            'description' => Yii::t('app', 'Description'),
            'end_date' => Yii::t('app', 'End date'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }
}
