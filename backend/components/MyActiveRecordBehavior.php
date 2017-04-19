<?php
namespace backend\components;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\Model;
use backend\models\AdminLog;

class MyActiveRecordBehavior extends Behavior
{
    private $logModel = null;
    
    public function adminLogRecord($model, $type = AdminLog::ACTION_TYPE_UPDATE)
    {
        $this->logModel = new AdminLog();
        
        if ($model instanceof ActiveRecord ) {
            if (AdminLog::ACTION_TYPE_DELETE == $type){
                $this->deleteRecordLog($model);
            }else{
                $this->activeRecordLog($model);
            }
		}elseif ($model instanceof Model){
		    $this->modelLog($model, $type);
		}
    }
    
    private function activeRecordLog($model)
    {
		if ( !$model->getIsNewRecord() ) {
// 			if ( Yii::$app->session->hasFlash($model->tableName(). '_Orig_Attribute') ) {
// 			    $origData= Yii::$app->session->getFlash($model->tableName(). '_Orig_Attribute');
// 				$newData= $model->attributes;
// 				$actionInfo = '更新数据ID#'. $model->getPrimaryKey().',';
// 				$insert = $modify = '';
// 				foreach ($newData as $k=> $v) {
// 					if(in_array($k,array('created_at','updated_at','create_user_id','update_user_id'))){
// 						continue;
// 					}
// 					if ( !isset($origData[$k]) && $origData[$k]!==null) {
	
// 						$insert .= "{$model->getAttributeLabel($k)},";
// 					} elseif ($newData[$k]!= $origData[$k]) {
						
// 						$modify .= "{$model->getAttributeLabel($k)},";
// 					}
// 				}
// 				$actionInfo .= $insert? '补充:"'.$insert.'"' : '';
// 				$actionInfo .= $modify? '修改:"'.$modify.'"' : '';
// 				//print_r($origData);print_r($newData);echo $actionInfo;die;
// 			} else {
// 				$actionInfo = '更新数据ID#'. $model->getPrimaryKey();
// 			}
		    $actionInfo = '更新数据ID#'. $model->getPrimaryKey();
			$this->logModel->actionRecord(AdminLog::ACTION_TYPE_UPDATE, array(
				'action_info'=> $actionInfo,
				'action_model'=> $model::className(),
			) );
		} else {
			$actionInfo = '新增数据ID#'. $model->getPrimaryKey();
			$this->logModel->actionRecord(AdminLog::ACTION_TYPE_CREATE, array(
				'action_info'=> $actionInfo,
				'action_model'=> $model::className(),
			) );
		}
		return '';
    }
    
    public function deleteRecordLog($model)
    {
        $actionInfo = '删除数据ID#'. $model->getPrimaryKey();
        $this->logModel->actionRecord(AdminLog::ACTION_TYPE_DELETE, array(
            'action_info'=> $actionInfo,
            'action_model'=> $model::className(),
        ) );
    }
    
    public function modelLog($model, $type)
    {
        if (AdminLog::ACTION_TYPE_LOGIN == $type){
            $actionInfo = '用户登录#' . (isset($model->username) ? $model->username : '');
        }elseif (AdminLog::ACTION_TYPE_SIGNUP == $type){
            $actionInfo = '用户注册#' . (isset($model->username) ? $model->username : '');
        }elseif (AdminLog::ACTION_TYPE_AUTH == $type){
            $actionInfo = '权限操作';
        }else{
            $actionInfo = '';
        }
        
        $this->logModel->actionRecord($type, array(
            'action_info'=> $actionInfo,
            'action_model'=> $model::className(),
        ) );
    }
}