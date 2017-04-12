<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '注册用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写以下字段:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php 
            $validationUrl = ['validate-signup-form'];
            #if (!$model->isNewRecord) {
            #    $validationUrl['id'] = $model->id;
            #}
            
            $form = ActiveForm::begin([
                'id' => 'form-signup',
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'validationUrl' => Url::toRoute($validationUrl),
            ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
