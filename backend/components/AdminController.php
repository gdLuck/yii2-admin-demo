<?php
/**
 * 扩展基础类
 */
namespace backend\components;

use yii;
use yii\web\Controller;
use yii\db\ActiveRecord;

class AdminController extends Controller
{
    /**
     * 为模型添加行为
     * @property yii\db\ActiveRecord | yii\base\Model $model  
     * AR类无需额外操作,model类需在成功处添加记录方法  
     * $model->modelLogRecord(Model $model, $type, $message = '')
     * @param object $model
     */
    public function attachAdminLogBehavior($model)
    {
        if ($model instanceof ActiveRecord){
            yii::$app->session->setFlash($model->tableName().'_Orig_Attribute', $model->attributes);
        }
        $model->attachBehavior('adminLogRecordBehavior', MyActiveRecordBehavior::className());
    }
}