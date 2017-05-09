<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TagManage */

$this->title = '创建分类标签';
$this->params['breadcrumbs'][] = ['label' => 'Tag Manages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-manage-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
