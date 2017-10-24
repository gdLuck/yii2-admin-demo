<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TagManage;
use backend\components\FormHelper;
use backend\components\BackendHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\TagManage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-manage-form">

    <?php $activeFormOptions = [
        'id' => 'tag-manage-form', #未设置则以 #w0开始
        //'method' => 'post',
        //'action' => ['controller/action'],
        'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data'],
        'enableClientValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n{hint}\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ];
    $form = ActiveForm::begin($activeFormOptions); ?>

    <?= $form->field($model, 't_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't_en_name')->textInput(['maxlength' => true])->hint('用于游戏搜索用可不设置') ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
            ArrayHelper::merge([0=> '顶级分类'], TagManage::subColumnList(TagManage::TAG_ID_PARENT)),
            ['prompt'=>'请选择所属父类']
       ); ?>
       
    <?= $form->field($model, 't_column')->dropDownList(
            FormHelper::getTagColumnList()
            //['prompt' => '请选择栏目', 'class'=> "form-control"]
       ); ?>

	<?= $form->field($model, 't_icon')->widget('common\widgets\file_upload\FileUpload',[
        'config'=>[
            //图片上传的一些配置，不写调用默认配置
            'isCdn' => false,
            'maxSize' => '1M',
        ]
    ]) ?>

    <?= $form->field($model, 't_status')->radioList(FormHelper::getStatusLabelOptions(), ['unselect'=> 0]); ?>

    <?= $form->field($model, 't_sort')->textInput(['maxlength' => true, 'class'=> 'col-lg-5']) ?>

    <div class="col-md-offset-1">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
          ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
$(function(){

	$("#tag-manage-form").submit(function(){
		if($("#tagmanage-parent_id option:selected").val() == ''){
			 alert("请选择所属父类"); return false;
		}
		return true;
	});
});
</script>