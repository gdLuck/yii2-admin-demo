<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'log_time')->textInput() ?>

    <?= $form->field($model, 'action_type')->textInput() ?>

    <?= $form->field($model, 'action_info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action_controller')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'remote_addr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
