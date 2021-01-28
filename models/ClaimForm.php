<?php

namespace app\models;

use app\components\DateTimeFormats;
use app\components\FileSaver;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * Class ClaimForm.
 *
 * @package app\models
 */
class ClaimForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $img;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $end_date;

    /**
     * @var int
     */
    public $status_id;

    /**
     * @var Claim
     */
    public $claim;

    /**
     * {@inheritDoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (is_null($this->claim)) {
            $this->claim = new Claim();
        }

        $this->title = $this->title ?? $this->claim->title;
        $this->description = $this->description ?? Html::decode($this->claim->description);
        $this->status_id = $this->status_id ?? $this->claim->status_id;

        if (!isset($this->end_date) && isset($this->claim->end_date)) {
            $this->end_date = Yii::$app->formatter->asDatetime(
                $this->claim->end_date,
                'php:' . DateTimeFormats::USER_FORMAT
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['img'], 'image'],
            [['title'], 'required'],
            [['description'], 'string'],
            [['end_date'], 'datetime', 'format' => 'php:' . DateTimeFormats::USER_FORMAT],
            [['status_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [
                ['status_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Status::class,
                'targetAttribute' => ['status_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'img' => Yii::t('app', 'Img'),
            'description' => Yii::t('app', 'Description'),
            'end_date' => Yii::t('app', 'End date'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

    /**
     * Save image, fill Claim object and save it.
     *
     * @return bool
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function save(): bool
    {
        $this->img = UploadedFile::getInstance($this, 'img');

        if (!$this->validate()) {
            return false;
        }

        if ($this->img instanceof UploadedFile) {
            /** @var FileSaver $fileSaver */
            $fileSaver = Yii::$app->fileSaver;

            $file = $fileSaver->save($this->img);

            if ($file instanceof File) {
                $this->claim->file_id = $file->id;
            } else {
                $this->addError('img', Yii::t('app', 'Error save image!'));

                return false;
            }
        }

        $this->claim->title = $this->title;
        $this->claim->description = Html::encode($this->description);
        $this->claim->status_id = $this->status_id;
        $this->claim->end_date = $this->end_date
            ? Yii::$app->formatter->asDatetime($this->end_date, 'php:' . DateTimeFormats::DB_FORMAT)
            : null;

        return $this->claim->save();
    }
}
