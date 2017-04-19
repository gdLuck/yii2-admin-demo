<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminLog */

$this->title = 'Update Admin Log: ' . $model->log_id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->log_id, 'url' => ['view', 'id' => $model->log_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
