<?php

use app\components\DateTimeFormats;
use app\models\Status;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClaimForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claim-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->fileInput([]) ?>

    <?php if ($model->claim->id) { ?>
        <div class="form-group">
            <label class="control-label"><?= Yii::t('app', 'Current image') ?></label><br>
            <?php if ($model->claim->file) { ?>
                <?= Html::a($model->claim->file->title, $model->claim->file->uploadPath, ['target' => '_blank']) ?>
            <?php } else { ?>
                <?= Yii::t('app', 'Image not set') ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?= $form->field($model, 'description')->widget(Widget::class, []) ?>

    <?= $form->field($model, 'end_date')->widget(DateTimePicker::class, [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => DateTimeFormats::PICKER_USER_FORMAT
        ]
    ]) ?>

    <?= $form->field($model, 'status_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Status::find()->all(), 'id', 'title'),
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
