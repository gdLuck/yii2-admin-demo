<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GameBasicInfo;

/**
 * GameBasicInfoSearch represents the model behind the search form about `common\models\GameBasicInfo`.
 */
class GameBasicInfoSearch extends GameBasicInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'game_state', 'game_sort', 'individuation', 'is_award', 'issue_status', 'steam_praise', 'steam_bad', 'add_time'], 'integer'],
            [['game_name', 'game_en_name', 'game_alias', 'game_name_spell', 'game_logo', 'game_head_img', 'game_intro', 'type_terrace', 'type_content', 'type_people', 'type_language', 'game_website', 'issue_time', 'steam_addr', 'update_time'], 'safe'],
            [['game_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GameBasicInfo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'game_id' => $this->game_id,
            'game_state' => $this->game_state,
            'game_sort' => $this->game_sort,
            'game_price' => $this->game_price,
            'individuation' => $this->individuation,
            'is_award' => $this->is_award,
            'issue_status' => $this->issue_status,
            'issue_time' => $this->issue_time,
            'steam_praise' => $this->steam_praise,
            'steam_bad' => $this->steam_bad,
            'add_time' => $this->add_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'game_name', $this->game_name])
            ->andFilterWhere(['like', 'game_en_name', $this->game_en_name])
            ->andFilterWhere(['like', 'game_alias', $this->game_alias])
            ->andFilterWhere(['like', 'game_name_spell', $this->game_name_spell])
            ->andFilterWhere(['like', 'game_logo', $this->game_logo])
            ->andFilterWhere(['like', 'game_head_img', $this->game_head_img])
            ->andFilterWhere(['like', 'game_intro', $this->game_intro])
            ->andFilterWhere(['like', 'type_terrace', $this->type_terrace])
            ->andFilterWhere(['like', 'type_content', $this->type_content])
            ->andFilterWhere(['like', 'type_people', $this->type_people])
            ->andFilterWhere(['like', 'type_language', $this->type_language])
            ->andFilterWhere(['like', 'game_website', $this->game_website])
            ->andFilterWhere(['like', 'steam_addr', $this->steam_addr]);

        return $dataProvider;
    }
}
