<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GameBasicInfo */

$this->title = '更新游戏: ' . $model->game_en_name;
$this->params['breadcrumbs'][] = ['label' => '游戏管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->game_en_name, 'url' => ['view', 'id' => $model->game_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-basic-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
