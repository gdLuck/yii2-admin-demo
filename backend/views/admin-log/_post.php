<?php
/**
 * 测试用
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\VarDumper;
?>
<div class="post">
	<?= VarDumper::dump($key);VarDumper::dump($index);?>
	
    <h3><?= $fullView ? Html::encode($context) : ''; ?></h3>
    
    <?= HtmlPurifier::process($model->action_info) ?>    
</div>