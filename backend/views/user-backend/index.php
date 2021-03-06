<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserBackendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-backend-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建新用户', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            // 'created_at',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view',
                    'update',
                    'delete' => function ($model) {
                        return $model->id != 1;
                    },
                ],         
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
