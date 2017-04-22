<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\VarDumper;
use backend\models\AdminLog;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.search_position{
	height: 70px;
    line-height: 70px;
    padding-left: 60%;
}
</style>

<div class="admin-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],#要提交到的控制器
        'method' => 'get', 
        'options' => [ #主全局配置
            //'class' => 'control-group',
        ],
        'fieldConfig' => [ #过滤字段全局配置 yii\widgets\ActiveField
            'options' => ['style' => 'float:left; margin-right: 10px;'],
            //'template' => "<sapn>{label}\n{input}\n{hint}\n{error}</span>",
        ],
        
    ]); ?>

	<?= $form->field($model, 'log_id', [
	    //'options'=>['style' => 'float:left;'],
	    //'template' => "<sapn>{label}\n{input}\n{hint}\n{error}</span>",
	]) #个性配置 ?>

    <?= $form->field($model, 'log_time') ?>
	
    <?= $form->field($model, 'action_type')->dropDownList(
        AdminLog::getActionType(),
        ['prompt'=>'选择事件类型']
    ); ?>

	<?php 
	#其他示例
	//echo $form->field($model, 'uploadFile[]')->fileInput(['multiple'=>'multiple']); 
	//echo $form->field($model, 'items[]')->checkboxList(['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']);
	//echo $form->field($model, 'status')->radioList([1=>'启用',0=>'禁用']);
	?>

    <?= $form->field($model, 'action_controller')->hint("test hint")->label('操作路由') #添加了一个小提示与自定义标签?>

    <div class="form-group search_position">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
