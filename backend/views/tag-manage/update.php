<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TagManage */

$this->title = '更新分类标签: ' . $model->t_id;
$this->params['breadcrumbs'][] = ['label' => 'Tag Manages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->t_id, 'url' => ['view', 'id' => $model->t_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-manage-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
