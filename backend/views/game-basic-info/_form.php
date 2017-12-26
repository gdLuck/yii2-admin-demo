<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use backend\components\BackendHelper;
use backend\models\TagManage;
use backend\components\FormHelper;
use common\widgets\WDatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\GameBasicInfo */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
/*
div.required label:after {
     content: " *";
     color: red;
}
*/
</style>

<div class="game-basic-info-form">

    <?php 
    $activeFormOptions = [
        'id' => 'game-besic-info-form', #未设置则以 #w0开始
        //'method' => 'post',
        //'action' => ['controller/action'],
        'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data'],
        'enableClientValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n{hint}\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ];
    $otherOptions = [
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to('/game-basic-info/ajax-verification'),
    ];
    
    !$model->isNewRecord ?: $activeFormOptions = ArrayHelper::merge($activeFormOptions, $otherOptions) ;
    
    $form = ActiveForm::begin($activeFormOptions); ?>

    <?= $form->field($model, 'game_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'game_en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'game_alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'game_logo')->widget('common\widgets\file_upload\fileUpload',[
            'config'=>[
                'isCdn'=> true,
            ]
        ]); ?>
            
    <?= $form->field($model, 'game_head_img')->widget('common\widgets\file_upload\fileUpload',[
            'config'=>[
                'isCdn'=> false,
            ]
        ]); ?>

    <?= $form->field($model, 'game_intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'game_sort')->textInput(['class'=> 'col-lg-6']) ?>

    <?= $form->field($model, 'type_terrace',['enableClientValidation'=> false,'enableAjaxValidation'=> false,])
        ->checkboxList(TagManage::subColumnList(TagManage::TAG_ID_TERRACE) )?>

	<?= $form->field($model, 'type_content',[
	    'enableClientValidation'=> false,
	    'enableAjaxValidation'=> false,
	    'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n{hint}\n<div class=\"col-lg-8\">{error}</div>",
	])->checkboxList(TagManage::subColumnList(TagManage::TAG_ID_CONTENT))?>
    
    <?= $form->field($model, 'type_people',['enableClientValidation'=> false,'enableAjaxValidation'=> false,])
        ->checkboxList(TagManage::subColumnList(TagManage::TAG_ID_PEOPLE) )?>
    
    <?= $form->field($model, 'type_language',['enableClientValidation'=> false,'enableAjaxValidation'=> false,])
        ->checkboxList(TagManage::subColumnList(TagManage::TAG_ID_LANGUAGE) )?>

    <?= $form->field($model, 'game_price')->textInput(['maxlength' => true, 'class'=> 'col-lg-6']) ?>

    <?= $form->field($model, 'game_website', [
        'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n{hint}\n<div class=\"col-lg-8\">{error}</div>",
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'individuation')->radioList(FormHelper::getStatusLabelOptions()) ?>
    
    <?= $form->field($model, 'is_award')->radioList(FormHelper::getStatusLabelOptions()) ?>

    <?= $form->field($model, 'issue_status')->radioList(FormHelper::getStatusLabelOptions()) ?>

    <?= $form->field($model, 'issue_time')->widget(WDatePicker::className(), [
        //'clientOptions' => ['defaultDate' => '2017-01-01'],  未见生效，须在模型设置默认值
        'dateFormat' => 'yyyy-MM-dd'
    ]) ?>

    <?= $form->field($model, 'steam_addr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'steam_praise')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'steam_bad')->textInput(['maxlength' => true]) ?>

    <div class="col-md-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
