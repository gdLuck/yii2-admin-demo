<?php
namespace backend\models;

use Yii;
use common\models\TagManage as BaseTagManage;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%tag_manage}}".
 *
 * @property integer $t_id
 * @property string $t_name
 * @property string $t_en_name
 * @property string $t_icon
 * @property integer $parent_id
 * @property integer $t_type
 * @property integer $t_status
 * @property string $t_sort
 * @property integer $t_column
 */
class TagManage extends BaseTagManage
{
    const STATUS_ACTIVE = 1; #启用
    const STATUS_DISABLE= 0;
    
    const TAG_ID_PARENT   = 0; #顶级分类
    const TAG_ID_TERRACE  = 4; #平台类型
    const TAG_ID_OPERATION = 3; #操作类型
    const TAG_ID_PEOPLE   = 23; #操作人数
    const TAG_ID_CONTENT = 2; #游戏类型
    const TAG_ID_LANGUAGE = 24; #语言
    
    
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_name'], 'required'],
            [['parent_id', 't_type', 't_status', 't_sort', 't_column'], 'integer'],
            [['t_column'], 'default', 'value' => 0],
            [['t_name', 't_en_name'], 'string', 'max' => 30],
            [['t_icon'], 'string', 'max' => 200],
            [['t_icon'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }
    
    /**
     * 取得子类分类标签 键值对
     * @property integer $tid
     * @return array
     */
    public static function subColumnList($tid)
    {
        $resultArr = TagManage::find()->select('t_id,t_name')->where(['parent_id'=> $tid, 't_status'=> self::STATUS_ACTIVE])
            ->asArray()->all();
        $result = ArrayHelper::map($resultArr, 't_id', 't_name');
        return $result;
    }
    
    
}
