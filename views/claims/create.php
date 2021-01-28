<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Claim */

$this->title = Yii::t('app', 'Create claim');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Claims'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
