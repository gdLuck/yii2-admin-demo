<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\UserBackend;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property string $log_id
 * @property string $log_time
 * @property integer $action_type
 * @property string $action_info
 * @property string $action_controller
 * @property string $action_model
 * @property integer $user_id
 * @property string $remote_addr
 * @property integer $status
 */
class AdminLog extends ActiveRecord
{
    const ACTION_TYPE_LOGIN  = 1;
    const ACTION_TYPE_CREATE = 2;
    const ACTION_TYPE_UPDATE = 3;
    const ACTION_TYPE_DELETE = 4;
    const ACTION_TYPE_AUTH   = 5;
    const ACTION_TYPE_SIGNUP = 6;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_time'], 'safe'],
            [['action_type', 'action_info'], 'required'],
            [['action_type', 'user_id', 'remote_addr', 'status'], 'integer'],
            [['action_info'], 'string', 'max' => 255],
            [['action_controller', 'action_model'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'ID',
			'log_time' => '操作时间',
			'action_type' => '事件类型',
			'action_info' => '事件摘要',
			'action_controller' => '操作控制器',
			'action_model' => '操作模型',
			'user_id' => '操作人',
			'remote_addr' => '操作IP',
			'status' => '状态',
        ];
    }
    
    /**
     * Write action record into table.
     * @param integer $type
     * @param array $option
     *    array(
     *    	'action_info'=> 'action description',
     *    	'action_model'=> 'resource name',
     *    )
     */
    public function actionRecord($type=self::ACTION_TYPE_LOGIN, $option=array() )
    {
        $userId= yii::$app->user->id;
        if(UserBackend::findOne($userId)) {
            $option['action_type'] = $type;
            $option['action_info'] = $option['action_info'];
            $option['action_model']= $option['action_model'];
            $option['action_controller'] = yii::$app->request->pathinfo;
            $option['user_id']	   = $userId;
            $option['remote_addr'] = ip2long(Yii::$app->request->userIP);
            $option['log_time']    = date('Y-m-d H:i:s');
            $this->attributes= $option;
            $this->save();
        }
    }
    /**
     * @return array 事件类型
     */
    public function getActionType()
    {
        $array = array(
            self::ACTION_TYPE_LOGIN  => '登录事件',
            self::ACTION_TYPE_CREATE => '创建数据',
            self::ACTION_TYPE_UPDATE => '更新数据',
            self::ACTION_TYPE_DELETE => '删除数据',
            self::ACTION_TYPE_AUTH   => '权限配置',
        );
    
        $ext_file = dirname(__FILE__).'/AdminLogType.php';
        $array_ext = array();
        if(file_exists($ext_file)){
            $array_ext = require($ext_file);
        }
        return ($array+$array_ext);
    }
}
