<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminLog;
use yii\helpers\VarDumper;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/**
 * AdminLogSearch represents the model behind the search form about `backend\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    /**
     * @var string
     */
    public $startTime,$endTime;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'action_type', 'user_id', 'remote_addr', 'status'], 'integer'],
            [['log_time', 'action_info', 'action_controller', 'action_model'], 'safe'],
            [['startTime'], 'default', 'value' => date('Y-m-d',strtotime('-1 week'))],
            [['endTime'], 'default', 'value' => date('Y-m-d')],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'startTime' => '开始时间',
            'endTime' => '结束时间'
        ], parent::attributeLabels());  
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
        $query = AdminLog::find(); #使用此，DataProvider返回可以是数组也可以是 Active Record 对象。
        //$query = (new Query())->from('{{%admin_log}}')
                #->where('action_type=4')->orderBy(['log_id'=>SORT_DESC]); #DataProvider->getModels 返回数组
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'db' => yii::$app->db,
            'query' => $query, #此必须其他可选
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'log_id' => SORT_DESC,#假如查询已经指定了 orderBy 从句，则终端用户给定的新的排序说明（通过 sort 来配置的） 将被添加到已经存在的从句中。
                    //'log_time' => SORT_DESC,
                ]
            ],
        ]);
        
        // 获取分页和排序数据
        #$models = $dataProvider->getModels();
        // 在当前页获取数据项的数目
        #$count = $dataProvider->getCount();
        // 获取所有页面的数据项的总数
        #$totalCount = $dataProvider->getTotalCount();
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'log_id' => $this->log_id,
            'action_type' => $this->action_type,
            'user_id' => $this->user_id,
            'remote_addr' => $this->remote_addr,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['>=', 'log_time', strtotime($this->startTime)]);
        $query->andFilterWhere(['<=', 'log_time', strtotime($this->endTime)]);
        
        $query->andFilterWhere(['like', 'action_info', $this->action_info])
            ->andFilterWhere(['like', 'action_controller', $this->action_controller])
            ->andFilterWhere(['like', 'action_model', $this->action_model]);
        
        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function sqlSearch($params)
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM {{%admin_log}} WHERE status=:status
        ', [':status' => 1])->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM {{%admin_log}} WHERE status=:status',
            'params' => [':status' => 1],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [ #参考yii\data\sort
                'attributes' => [
                    'log_id' => [
                        'default' => SORT_DESC,
                    ],
                ],
            ],
        ]);
        
    
        // 获取分页和排序数据
        $models = $dataProvider->getModels();
        //echo json_encode($models);exit;
        // 在当前页获取数据项的数目
        #$count = $dataProvider->getCount();
        // 获取所有页面的数据项的总数
        #$totalCount = $dataProvider->getTotalCount();
    
        //$this->load($params);
    
    
        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function arraySearch($params)
    {
        $data = (new Query())->from('{{%admin_log}}')->all();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => [
                'attributes' => [
                    'log_id' => [
                        'asc' => ['log_id' => SORT_ASC],
                        'desc' => ['log_id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'log_id',
                    ],
                ],
            ],
        ]);

        // 获取当前请求页的每一行数据
        //$rows = $dataProvider->getModels();
        //VarDumper::dump($rows);die();
        // 在当前页获取数据项的数目
        #$count = $dataProvider->getCount();
        // 获取所有页面的数据项的总数
        #$totalCount = $dataProvider->getTotalCount();
    
        //$this->load($params);
    
        return $dataProvider;
    }
}
