<?php

use backend\models\UserBackend;
use backend\components\BackendHelper;

/* @var $this yii\web\View */

$this->title = '欢迎 '.UserBackend::getUsername(yii::$app->getUser()->id).' 登陆后台管理系统 ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => 'vr,vrgame,vrvideo', 'description']); #防止重复
$this->registerMetaTag(['name' => 'description', 'content' => '这是描述~！', 'description']); #描述
?>
<div class="box box-info">
	<h1>系统信息</h1>
    <div class="box-body" style="display: block;">
    	<div class="table-responsive">
        	<table class="table no-margin">
    			<tbody>
                	<tr>
                        <td>现在时间</td>
                        <td><?= date("Y-m-d H:i:s"); ?></td>
                    </tr>
                    <tr>
                		<td >您的ip</td>
                		<td ><?= yii::$app->getRequest()->userIP; ?></td>
              		</tr>
              		<tr>
                        <td >服务器ip</td>
                        <td ><?= BackendHelper::getMyIp(); ?></td>
                    </tr>
                    <tr>
                    	<td >操作系统软件</td>
                        <td ><?= $server['serverOs']?> - <?= $server['serverSoft']?></td>
                    </tr>
                    <tr>
                        <td >上传许可</td>
                        <td ><?= $server['fileupload']?></td>
                    </tr>
                    <tr>
                        <td >主机名</td>
                        <td ><?= $server['serverUri']?></td>
                    </tr>
                    <tr>
                        <td >当前使用内存</td>
                        <td ><?= $server['excuteUseMemory']?></td>
                    </tr>
                    <tr>
                        <td >PHP环境</td>
                        <td ><?= $server['phpVersion']?></td>
                    </tr>
    			</tbody>
    		</table>
    	</div>
        <!-- /.table-responsive -->
        
    </div>
</div>
