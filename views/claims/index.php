<?php

use app\components\DateTimeFormats;
use app\models\Claim;
use app\models\Status;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ClaimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Claims');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create claim'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'readonly' => true,
                    'hideInput' => true,
                    'presetDropdown' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'timePicker' => true,
                        'timePickerSeconds' => true,
                        'timePicker24Hour' => true,
                        'locale' => [
                            'format' => DateTimeFormats::USER_FORMAT,
                        ],
                    ],
                ]),
            ],
            [
                'attribute' => 'end_date',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'end_date',
                    'readonly' => true,
                    'hideInput' => true,
                    'presetDropdown' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'timePicker' => true,
                        'timePickerSeconds' => true,
                        'timePicker24Hour' => true,
                        'locale' => [
                            'format' => DateTimeFormats::USER_FORMAT,
                        ],
                    ],
                ]),
            ],
            [
                'attribute' => 'status_id',
                'value' => function ($model) {
                    /** @var Claim $model */
                    return $model->status ? $model->status->title : null;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status_id',
                    'data' => ArrayHelper::map(Status::find()->all(), 'id', 'title'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
