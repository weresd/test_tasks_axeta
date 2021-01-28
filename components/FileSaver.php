<?php

namespace app\components;

use app\models\File;
use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Class FileSaver.
 *
 * Component for manage files.
 *
 * @package app\components
 */
class FileSaver extends Component
{
    /**
     * Full path to upload dir.
     *
     * @var string
     */
    public $uploadDir;

    /**
     * Permission list.
     *
     * @var array
     */
    public $permissions = [
        'file' => 0644,
        'dir' => 0755,
    ];

    /**
     * {@inheritDoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->uploadDir = rtrim(Yii::getAlias($this->uploadDir), '\\/');
    }

    /**
     * Save file to upload dir and save information about it in DB.
     *
     * @param UploadedFile $uploadedFile
     *
     * @return File|null
     *
     * @throws Exception
     */
    public function save(UploadedFile $uploadedFile): ?File
    {
        $relativeUploadDir = date('Ymd') . DIRECTORY_SEPARATOR . date('H');
        $fullUploadDir = $this->uploadDir . DIRECTORY_SEPARATOR . $relativeUploadDir;

        if (!file_exists($fullUploadDir) && !mkdir($fullUploadDir, $this->permissions['dir'], true)) {
            return null;
        }

        $newFileName = Yii::$app->security->generateRandomString(16) . '.' . $uploadedFile->getExtension();

        if (!copy($uploadedFile->tempName, $fullUploadDir . DIRECTORY_SEPARATOR . $newFileName)) {
            return null;
        }

        $file = new File([
            'title' => $uploadedFile->name,
            'path' => $relativeUploadDir . DIRECTORY_SEPARATOR . $newFileName,
            'type' => $uploadedFile->type
        ]);

        if (!$file->save()) {
            unlink($fullUploadDir . DIRECTORY_SEPARATOR . $newFileName);

            return null;
        }

        return $file;
    }
}
