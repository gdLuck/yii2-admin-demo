<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\db\Query;
use yii\helpers\VarDumper;

class QueryTestController extends Controller
{
    public function actionQuery()
    {
        $query = new Query();
        
        $username = 'admin';
        $subQuery = (new Query())->from('country')->limit(5);//调用子查询时必须重新实例化 query
        
        $result = $query->select(['code_name' => " CONCAT(code, ' ', name) ", 'population', 'users.id'])
        ->addSelect('users.username')
        ->from(['table_alias' => $subQuery, 'yii2basic.users'])
        //->where('users.id=:id or id=:id2 ',[':id' => 1])
        //->addParams([':id2' => 2])
        //->where(['and', 'id=:id', 'username=:username'], [':id' => 1,':username' => 'admin'])
        //->where(['or', 'id=1',['and', 'id=2', 'username="test" ']]) #如果操作数是一个数组  这个方法不会自动加引号或者转义。
        ->where(['between', 'id', 1, 2])
        //->where(['not between', 'id', 2, 3])
        //->where(['in', ['id','username'], [['id'=>1,'username'=>'admin'],['id'=>2,'username'=>'test']]]) #['in', 'id', [1, 2, 3]]
        //->where(['not in', 'id', (new Query())->select('id')->from('users')->where('id=:id', [':id'=>2]) ])
        //->where(['like', 'name', ['ch', 'a']])  # 默认使用转义，并两则加上%， 若不想可第三个参数为false 例 ：['like', 'name', 'ch%', false]
        //->where(['or like', 'name', ['ch', 'a']]) # 改用 or 关联
        //->where(['not like', 'name', 'ch'])
        //->where(['or not like', 'name', ['ch','a']])
//         ->where(['exists', (new Query())
//             ->select('id')
//             ->from(['users_alias'=>'users'])
//             ->where('users.id=users_alias.id and users_alias.id in(1)')
//         ])
        //->where(['<', 'id', 2])
        
/* andWhere 与 orWhere */
        //->andWhere(['username' => 'admin'])        
        //->orWhere(['username' => 'admin'])
        
/* filterWhere | andFilterWhere #作用：当用户输入的数据为空不合理时忽略条件 */
//         ->filterWhere([
//             'username'=>$username,
//         ])
        ->filterWhere(['between', 'id', 1 ,1])
//         ->andFilterWhere(['username' => 'admin'])
        ->orFilterWhere(['like', 'username', 't'])
        
/* order by | add order by */
//         ->orderBy([
//             'id' => SORT_DESC,# SORT_ASC
//         ])
        //->orderBy('id DESC,name ASC')
        ->orderBy([
            'population' => SORT_DESC
        ])
        ->addOrderBy('id DESC')
        
/* group by | add group by*/
        //->groupBy(['username'])
        //->addGroupBy('id')
        
/* having | andHaving |orHaving */
        //->having(['username'=> 'admin'])
        
        ->limit(3)->offset(1)
        
/* 返回数组索引方式 */
        //->indexBy('code_name')
//         ->indexBy(function($row){
//             return $row['id'] . $row['username'];
//         })
        
        ->distinct()
        ->all();
/* 查看生成的SQL代码 */
        //->createCommand();//要查看代码时使用
        //echo $result->sql; //查看生成的SQL代码
        //$result = $result->queryAll();
        
        VarDumper::dump($result);
    }
    
    /**
     * join|innerjoin|leftjoin|rightjoin
     * union
     */
    public function actionOtherMethod()
    {
        //$query1 = (new Query())->from('users')->where(['in', 'id', [1,2]]);
        //$query2 = (new query())->from('users')->where(['id'=>3]);
        //$result = $query1->union($query2)->all();
        
        //$query = new Query();
        //$result = $query->from('country')
        //->where(['>', 'population', '100000'])
        //->count();
        //->max('population');
        //->min('population');
        //->sum('population');
        //->average('population');
        
        /* join */
        $query = new Query();
        $result = $query->select(['a_id' => 'a.id', 'a_username'=>'a.username', 'b_id' =>'b.id', 'c_id'=>'c.id'])
        ->from(['a' =>'users'])
        ->join('join', ['b' =>'users'], 'a.id=b.id')
        ->innerJoin(['c' =>'users'], 'a.id=c.id')
        //->leftJoin(['b' =>'users'], 'a.id=b.id')
        //->rightJoin(['b' =>'users'], 'a.id=b.id')
        
        ->all();
        
        VarDumper::dump($result);
    }
    
}