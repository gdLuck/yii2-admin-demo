<?php

namespace backend\models;

use Yii;
use common\models\GameExtension as BaseGameExtension;

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
class GameExtension extends BaseGameExtension
{
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
    
    //贪婪加载配置
    public function getGameBasicInfo()
    {
        return $this->hasOne(GameBasicInfo::className(), ['game_id' => 'game_id']);
    }
}
