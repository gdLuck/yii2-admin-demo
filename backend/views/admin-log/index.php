<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\DataColumn;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use backend\models\AdminLog;
use backend\components\AdminHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
	<div></div>
<?php Pjax::begin(); ?> 
    
    <?php 
//     echo ListView::widget([
//         'dataProvider' => $dataProvider,
//         'itemView' => '_post', #此视结构将会被循环处理
//         'viewParams' => [ #要附加的数据，可选项
//             'fullView' => true,
//             'context' => 'main-page',
//             // ...
//         ],
//     ]);
    ?>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],  #连续ID列
            [
                'class' => CheckboxColumn::className(), #多选框列  JS调用方法 var keys = $('#grid').yiiGridView('getSelectedRows');
                //'checkboxOptions' => ['class'=>'ckeckboxTest'],
            ],
            [
                'class' => DataColumn::className(), // 默认可不设置
                'attribute' => 'log_id',
                'headerOptions' => ['style'=>'width:100px'],
                'format' => 'text',
                'label' => '序列ID',
            ],
            [
                'attribute' => 'log_time',
                'value' => function ($model, $key, $index, $column) {
                    return date('Y-m-d H:i:s',$model->log_time);
                },
            ],
            [
                'attribute' => 'action_type',
                'content'  => function ($model, $key, $index, $column) {#可获取值 $column 为 yii\grid\Column对象  写value或content都可
                    return AdminHelper::getLogTypeLabel($model->action_type);
                },
                'contentOptions' => ['class'=>['test content']], #设置行属性
                'format' => 'text',
                //'header' => 'test head', #
            	'headerOptions' => [
            	    'class' => ['test header'],
            	    'style' => 'width:150px',
            	    'data'  => ['id' => 1, 'name' => 'type']
            	],#追加到头部内容
                //'footer' => '',#待深入研究
                //'footerOptions' => [],
                'filterOptions' => ['class'=>'test filter'], #搜索栏、过滤栏
                //'visible' => false,
            ],
            'action_info',
            'action_controller:text:操作路由', #快捷方法,
            
            [
                'class' => 'yii\grid\ActionColumn',#操作栏
                'header'=> '操作',
                'controller' => 'admin-log/index', #未设置默认当前
                'template'=>'{view}{test}',
                'buttons' => [
                    'test' => function ($url, $model, $key) {
                        return $model->status === 1 ? Html::a('{test}', $url) : '';
                    },
            	],
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return $model->status === 1;
                    },
                    //'update' => \Yii::$app->user->can('update'), #检查权限
                    //'delete' => true,
                ],
                #'urlCreator' => function ($action, $model, $key, $index, $this){ #自定义回调函数用于生成 URL路径
                #    return 'test url';
                #},
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>


<div>
	<span><?= html::button('多选测试1',['id' =>'ckeckboxTest1']);?></span>
	<span><?= html::button('多选测试2',['id' =>'ckeckboxTest2']);?></span>
</div>

<script>
$(document).ready(function(){
	$("#ckeckboxTest1").click(function(){
		var keys = $('.grid-view').yiiGridView('getSelectedRows');  //若启用了PJAX并修改了APPAsset 并且未指定ID #grid则改为 .grid-view 或#w0
		console.log(keys);
//  		$.ajax({
//              type: "POST",
//             url: "", #<?= \yii\helpers\Url::to(['/controller/action']); ?>
//              dataType: "json",
//              data: {keylist: keys}
//         });
	});
	$("#ckeckboxTest2").click(function(){
		var keys = $('#w1').yiiGridView('getSelectedRows');  //若启用了PJAX并修改了APPAsset  多个column并存时 按调用顺序改  如：#w1
		console.log(keys);
	});
	
});
</script>
