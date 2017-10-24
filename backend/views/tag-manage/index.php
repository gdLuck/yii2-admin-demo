<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\widgets\GotoLinkPager;
use backend\components\FormHelper;
use backend\components\BackendHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TagManageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类标签管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-manage-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建标签', ['create'], ['class' => 'btn btn-success']) ?>
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
            //['class' => 'yii\grid\SerialColumn'],

            't_id',
            'parent_id',
            't_name',
            [
                'attribute' => 't_icon',
                'filter' => false,
                'value' => function ($model){
                    return FormHelper::getImageHtml($model->t_icon, false, 50);
                },
                'format' => 'html',
                'header' => '图标', #禁用排序，只展示文本
            ],
            [
                'attribute' => 't_status',
                'filter' => Html::activeDropDownList(
                    $searchModel, 't_status',
                    FormHelper::getStatusLabelOptions(),
                    ['class' => 'form-control','prompt'=>'']
                ),
                'value' => function ($model){
                    return FormHelper::getStatusLabelIcon($model->t_status);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 't_column',
                'filter' => Html::activeDropDownList(
                    $searchModel, 't_column',
                    FormHelper::getTagColumnList(),
                    ['class' => 'form-control', 'prompt'=>'']
                ),
                'value' => function ($model){
                    return FormHelper::getTagColumnName($model->t_column);
                },
                'format' => 'html',
            ],
            ['attribute'=>'t_sort', 'filter'=> false],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
