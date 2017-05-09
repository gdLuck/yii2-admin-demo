<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\widgets\GotoLinkPager;
use backend\components\FormHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GameBasicInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '游戏基础信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-basic-info-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增游戏', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>array(
            'class'=> GotoLinkPager::className(),
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'goPageLabel' => true,
            'totalPageLable' => '共x页',
            'maxButtonCount' => 10
        ),
    
        'columns' => [
            ['attribute' => 'game_id','headerOptions' => ['style'=>'width:70px']],
            'game_name',
            'game_en_name',
            ['attribute' => 'game_sort','filter' => false],
            [
                'attribute' => 'game_state',
                'filter' => Html::activeDropDownList($searchModel, 'game_state', FormHelper::getStatusLabelOptions(), ['class' => 'form-control']),
                'format' => 'html',
                'value' => function ($model) {
                    return FormHelper::getStatusLabelIcon($model->game_state);
                },
            ],
            [
                'attribute' => 'issue_status',
                'filter' => Html::activeDropDownList($searchModel, 'issue_status', FormHelper::getStatusLabelOptions(), ['class' => 'form-control']),
                'value' => function ($model){
                    return FormHelper::getStatusLabelIcon($model->issue_status);
                },
                'format' => 'html',
            ],
            'issue_time',#
            [
                'attribute' => 'game_website',
                'filter' => Html::activeTextInput($searchModel, 'game_website', ['class' => 'form-control']),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a("地址", $model->game_website, ['target'=>'_blank']);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> '操作',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
