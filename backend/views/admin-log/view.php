<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminLog */

$this->title = $model->log_id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'log_id',
            'log_time',
            'action_type',
            'action_info',
            'action_controller',
            'action_model',
            'user_id',
            'remote_addr',
            'status',
            //['label'=>'gender','value'=>$model->getGenderText()],
        ],
        //'template' => '<tr><th>{label}</th><td>{value}</td></tr>',
        //'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>
