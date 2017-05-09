<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GameBasicInfo */

$this->title = $model->game_id;
$this->params['breadcrumbs'][] = ['label' => 'Game Basic Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-basic-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->game_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->game_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'game_id',
            'game_name',
            'game_en_name',
            'game_alias',
            'game_name_spell',
            'game_logo',
            'game_head_img',
            'game_intro:ntext',
            'game_state',
            'game_sort',
            'type_terrace',
            'type_content',
            'type_people',
            'type_language',
            'game_price',
            'game_website',
            'individuation',
            'is_award',
            'issue_status',
            'issue_time',
            'steam_addr',
            'steam_praise',
            'steam_bad',
            'add_time:datetime',
            'update_time',
        ],
    ]) ?>

</div>
