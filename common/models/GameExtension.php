<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%game_extension}}".
 *
 * @property string $e_id
 * @property integer $game_id
 * @property string $e_system
 * @property string $e_cpu
 * @property string $e_memory
 * @property string $e_card
 * @property integer $e_direct
 * @property string $e_space
 * @property integer $update_time
 * @property integer $add_time
 */
class GameExtension extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game_extension}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'update_time', 'add_time'], 'required'],
            [['game_id', 'e_direct', 'update_time', 'add_time'], 'integer'],
            [['e_system', 'e_cpu'], 'string', 'max' => 50],
            [['e_memory', 'e_space'], 'string', 'max' => 20],
            [['e_card'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'e_id' => '序列ID',
            'game_id' => '游戏ID',
            'e_system' => '操作系统',
            'e_cpu' => '处理器',
            'e_memory' => '内存',
            'e_card' => '显卡',
            'e_direct' => 'directX 支持版本',
            'e_space' => '存储空间(G)',
            'update_time' => '更新时间',
            'add_time' => '添加时间',
        ];
    }
}
