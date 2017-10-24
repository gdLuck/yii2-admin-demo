<?php
namespace backend\models;

use Yii;
use common\models\GameBasicInfo as GameBasic;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%game_basic_info}}".
 *
 * @property integer $game_id
 * @property string $game_name
 * @property string $game_en_name
 * @property string $game_alias
 * @property string $game_name_spell
 * @property string $game_logo
 * @property string $game_head_img
 * @property string $game_intro
 * @property integer $game_state
 * @property integer $game_sort
 * @property string $type_terrace
 * @property string $type_content
 * @property string $type_people
 * @property string $type_language
 * @property string $game_price
 * @property string $game_website
 * @property integer $individuation
 * @property integer $is_award
 * @property integer $issue_status
 * @property string $issue_time
 * @property string $steam_addr
 * @property string $steam_praise
 * @property string $steam_bad
 * @property integer $add_time
 * @property string $update_time
 */
class GameBasicInfo extends GameBasic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //普通错误提示
            [['game_en_name', 'type_terrace', 'type_content', 'type_people', 'type_language'], 'required', 'message' => '不可以为空'],
            [['game_intro'], 'string', 'min' => 10, 'tooShort' => '至少10个描述'],
            [['game_state', 'game_sort', 'individuation', 'is_award', 'issue_status', 'steam_praise', 'steam_bad', 'add_time'], 'integer'],
            [['game_price'], 'number', 'max'=> 1000, 'min'=>0,'tooBig'=> '值不应大于1000', 'tooSmall'=> '不可小于0'], #数值型错误提示
            [['issue_time', 'update_time'], 'safe'],
            [['game_name', 'game_alias'], 'string', 'max' => 20],
            [['game_en_name', 'type_people', 'type_language'], 'string', 'max' => 50],
            [['game_name_spell', 'game_logo', 'game_head_img', 'game_website', 'steam_addr'], 'string', 'max' => 255],
            [['type_terrace', 'type_content'], 'string', 'max' => 90],
            [['game_alias'], 'unique', 'message'=> '游戏别名不可重复'], #'targetClass' => '\backend\models\gameBasicInfo' 非AR时定义用于查询
            [['game_logo','game_head_img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg, png, jpg'],
        ];
    }
    
    /**
     * {@inheritDoc}
     * @see \yii\base\Component::behaviors()
     */
//     public function behaviors()
//     {
//         return [
//             [
//                 'class' => TimestampBehavior::className(),
//                 'attributes' => [
//                     ActiveRecord::EVENT_BEFORE_INSERT => ['add_time', 'update_time'],
//                     ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
//                 ],
//                 // if you're using datetime instead of UNIX timestamp:
//                 'value' => [
//                     'add_time' => time(),
//                     'update_time' => new Expression('NOW()'),
//                 ]
//             ],
//         ];
//     }
    
    //贪婪加载配置 一对一
    public function getGameExtension()
    {
        return $this->hasOne(GameExtension::className(), ['game_id' => 'game_id']);
    }
}
