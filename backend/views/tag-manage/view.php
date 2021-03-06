<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TagManage */

$this->title = $model->t_id;
$this->params['breadcrumbs'][] = ['label' => 'Tag Manages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-manage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->t_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->t_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            't_id',
            't_name',
            't_en_name',
            't_icon',
            'parent_id',
            't_type',
            't_status',
            't_sort',
            't_column',
        ],
    ]) ?>

</div>
