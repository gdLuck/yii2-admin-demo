<?php

namespace common\models;

use Yii;

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
class GameBasicInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game_basic_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_en_name','game_head_img', 'type_terrace', 'type_content', 'type_people', 'type_language', 'add_time'], 'required'],
            [['game_intro'], 'string'],
            [['game_state', 'game_sort', 'individuation', 'is_award', 'issue_status', 'steam_praise', 'steam_bad', 'add_time'], 'integer'],
            [['game_price'], 'number'],
            [['issue_time', 'update_time'], 'safe'],
            [['game_name', 'game_alias'], 'string', 'max' => 20],
            [['game_en_name', 'type_people', 'type_language'], 'string', 'max' => 50],
            [['game_name_spell', 'game_logo', 'game_head_img', 'game_website', 'steam_addr'], 'string', 'max' => 255],
            [['type_terrace', 'type_content'], 'string', 'max' => 90],
            [['game_alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'game_name' => '游戏名',
            'game_en_name' => '英文名',
            'game_alias' => '游戏别名',# 域名目录（用于URL路径显示）
            'game_name_spell' => '拼音简写',
            'game_logo' => '缩略图',#
            'game_head_img' => '游戏详情页头图',
            'game_intro' => '简介',# 500字以内 手机版取180字
            'game_state' => '游戏状态',#  1启用 2冻结
            'game_sort' => '排序',#  默认60 降序
            'type_terrace' => '平台类型',
            'type_content' => '游戏类型',
            'type_people' => '人数',#  1 单人、2 多人
            'type_language' => '语言',#  1 中文、 2 英文
            'game_price' => '游戏价格',#  精确到两位小数
            'game_website' => '官网地址',
            'individuation' => '是否个性化',# 0 否（默认） 1是
            'is_award' => '是否显示奖项',# 0否（默认） 1是
            'issue_status' => '是否发行',#  0否  1是
            'issue_time' => '发行时间',#  前端显示到月
            'steam_addr' => 'steam地址',
            'steam_praise' => 'steam好评数',
            'steam_bad' => 'steam差评数',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
        ];
    }
}
