<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TagManageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-manage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 't_id') ?>

    <?= $form->field($model, 't_name') ?>

    <?= $form->field($model, 't_en_name') ?>

    <?= $form->field($model, 't_icon') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 't_type') ?>

    <?php // echo $form->field($model, 't_status') ?>

    <?php // echo $form->field($model, 't_sort') ?>

    <?php // echo $form->field($model, 't_column') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
