<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GameBasicInfo */

$this->title = '更新游戏: ' . $model->game_id;
$this->params['breadcrumbs'][] = ['label' => 'Game Basic Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->game_id, 'url' => ['view', 'id' => $model->game_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-basic-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
