<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Claim */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Claims'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="claim-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'file_id',
                'format' => 'raw',
                'value' => $model->file
                    ? Html::a($model->file->title, $model->file->uploadPath, ['target' => '_blank'])
                    : null,
            ],
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => $model->description ? Html::decode($model->description) : null,
            ],
            'created_at:datetime',
            'end_date:datetime',
            [
                'attribute' => 'status_id',
                'value' => $model->status ? $model->status->title : null,
            ],

        ],
    ]) ?>

</div>
