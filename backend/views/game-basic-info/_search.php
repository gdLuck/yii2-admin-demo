<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GameBasicInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-basic-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'game_id') ?>

    <?= $form->field($model, 'game_name') ?>

    <?= $form->field($model, 'game_en_name') ?>

    <?= $form->field($model, 'game_alias') ?>

    <?= $form->field($model, 'game_name_spell') ?>

    <?php // echo $form->field($model, 'game_logo') ?>

    <?php // echo $form->field($model, 'game_head_img') ?>

    <?php // echo $form->field($model, 'game_intro') ?>

    <?php // echo $form->field($model, 'game_state') ?>

    <?php // echo $form->field($model, 'game_sort') ?>

    <?php // echo $form->field($model, 'type_terrace') ?>

    <?php // echo $form->field($model, 'type_content') ?>

    <?php // echo $form->field($model, 'type_people') ?>

    <?php // echo $form->field($model, 'type_language') ?>

    <?php // echo $form->field($model, 'game_price') ?>

    <?php // echo $form->field($model, 'game_website') ?>

    <?php // echo $form->field($model, 'individuation') ?>

    <?php // echo $form->field($model, 'is_award') ?>

    <?php // echo $form->field($model, 'issue_status') ?>

    <?php // echo $form->field($model, 'issue_time') ?>

    <?php // echo $form->field($model, 'steam_addr') ?>

    <?php // echo $form->field($model, 'steam_praise') ?>

    <?php // echo $form->field($model, 'steam_bad') ?>

    <?php // echo $form->field($model, 'add_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
