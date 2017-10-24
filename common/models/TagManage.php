<?php

namespace common\models;

use Yii;

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
class TagManage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag_manage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_name'], 'required'],
            [['parent_id', 't_type', 't_status', 't_sort', 't_column'], 'integer'],
            [['t_name', 't_en_name'], 'string', 'max' => 30],
            [['t_icon'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            't_id' => '分类ID',
            't_name' => '分类名称',
            't_en_name' => '分类英文别名',
            't_icon' => '分类图标',
            'parent_id' => '父级ID',
            't_type' => '标签类型',# 1 单选 2 多选 顶级分类使用
            't_status' => '分类状态',# 0 禁用 1 启用
            't_sort' => '排序',# 默认0 无符号
            't_column' => '所属栏目',# 1 游戏 2 视频
        ];
    }
}
