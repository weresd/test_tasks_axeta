<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $title Название
 * @property string $path Путь к файлу
 * @property string|null $type Тип файла
 *
 * @property-read Claim[] $claims
 * @property-read string $uploadPath
 */
class File extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'path'], 'required'],
            [['title'], 'string', 'max' => 256],
            [['path'], 'string', 'max' => 512],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'path' => 'Path',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Claims]].
     *
     * @return ActiveQuery
     */
    public function getClaims()
    {
        return $this->hasMany(Claim::class, ['file_id' => 'id']);
    }

    /**
     * Return file path begin upload dir.
     *
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::$app->params['upload_dir'] . DIRECTORY_SEPARATOR . $this->path;
    }
}
