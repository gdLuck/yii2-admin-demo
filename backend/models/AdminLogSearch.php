<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form about `backend\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'action_type', 'user_id', 'remote_addr', 'status'], 'integer'],
            [['log_time', 'action_info', 'action_controller', 'action_model'], 'safe'],
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
        $query = AdminLog::find();

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
            'log_id' => $this->log_id,
            'log_time' => $this->log_time,
            'action_type' => $this->action_type,
            'user_id' => $this->user_id,
            'remote_addr' => $this->remote_addr,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'action_info', $this->action_info])
            ->andFilterWhere(['like', 'action_controller', $this->action_controller])
            ->andFilterWhere(['like', 'action_model', $this->action_model]);

        return $dataProvider;
    }
}
