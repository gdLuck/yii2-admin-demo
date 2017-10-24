<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TagManage;

/**
 * TagManageSearch represents the model behind the search form about `backend\models\TagManage`.
 */
class TagManageSearch extends TagManage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_id', 'parent_id', 't_type', 't_status', 't_sort', 't_column'], 'integer'],
            [['t_name', 't_en_name', 't_icon'], 'safe'],
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
        $query = TagManage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'parent_id' => SORT_ASC,#假如查询已经指定了 orderBy 从句，则终端用户给定的新的排序说明（通过 sort 来配置的） 将被添加到已经存在的从句中。
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            't_id' => $this->t_id,
            'parent_id' => $this->parent_id,
            't_type' => $this->t_type,
            't_status' => $this->t_status,
            't_sort' => $this->t_sort,
            't_column' => $this->t_column,
        ]);

        $query->andFilterWhere(['like', 't_name', $this->t_name])
            ->andFilterWhere(['like', 't_en_name', $this->t_en_name])
            ->andFilterWhere(['like', 't_icon', $this->t_icon]);

        return $dataProvider;
    }
}
