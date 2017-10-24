<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\VarDumper;
use yii\db\Transaction;

class MysqlTestController extends Controller
{
    /**
     * sql 各种取数据测试
     */
    public function actionSelectTest()
    {
        //返回多行. 每行都是列名和值的关联数组.如果该查询没有结果则返回  空数组
//         $result = yii::$app->db->createCommand('SELECT * FROM country')->queryAll();
        
        // 返回一行 (第一行) 如果该查询没有结果则返回  false
//         $result = Yii::$app->db->createCommand('SELECT * FROM country WHERE code=1')->queryOne();
        
        // 返回一列 (第一列)  如果该查询没有结果则返回  空数组
//         $result = Yii::$app->db->createCommand('SELECT `code` FROM country')->queryColumn();
        
        // 返回一个标量值  如果该查询没有结果则返回  false
//         $result = Yii::$app->db->createCommand('SELECT COUNT(*) FROM country')->queryScalar();
        
        /* 绑定参数法  使用不同参数多次执行， 来提升性能。 */
        $command = yii::$app->db->createCommand('SELECT * FROM country WHERE `name`=:name ');
//         $result  = $command->bindValue(':name', 'china')->queryOne();//mysql 默认不区分大小写，可使用二进制类型区分大小写BINARY
        $result  = $command->bindValue(':name', 'canada')->queryOne();
        
        $params = [':name' => '%a%' , ':population' => 2000000];
//         $result = yii::$app->db->createCommand("SELECT * FROM country WHERE `name` LIKE :name AND population >:population ")
//         ->bindValues($params)->queryAll();  #方法一
        
//         $result = yii::$app->db->createCommand("SELECT * FROM country WHERE `name` LIKE :name AND population >:population ", $params)
//         ->queryAll(); #方法二
        
        VarDumper::dump($result);
    }
    
    public function actionOtherTest()
    {
        #更新  {{%country}} 添加百分号时将使用表前缀
        $result = yii::$app->db->createCommand('UPDATE {{country}} SET population=population+10000 WHERE [[name]] = :name')
        ->bindValue(':name', 'china')->execute();
        
//         $result = yii::$app->db->createCommand()
//         ->update( '{{country}}', ['[[population]]' => '10000' ], ' [[code]] like :code ', [':code'=> '%a%'])
//         ->execute();
        #添加
//         $result = yii::$app->db->createCommand()->insert('{{country}}', [
//             'code' => 'GT',
//             'name' => 'test',
//             'population' => '111000',
//         ])->execute();

//         $result = yii::$app->db->createCommand()->batchInsert('{{country}}', ['code', 'name', 'population'], [
//             ['GT', 'TEST1', '111333'],
//             ['NG', 'test2', '222333'],
//         ])->execute();
        
        #删除  返回处理行数
//         $result = yii::$app->db->createCommand()->delete('{{country}}', ' `code` in("GT","NG") ')
//         ->execute();
        
        VarDumper::dump($result);
    }
    
    /**
     * 事务处理   # MySQL的默认隔离级别就是Repeatable read。即可幻读
     * $isolationLevel = \yii\db\Transaction::REPEATABLE_READ;  //可重载默认的隔离级别
     * Yii::$app->db->transaction(function($db) {
         $db->createCommand($sql1)->execute();
         $db->createCommand($sql2)->execute();
         // ... executing other SQL statements ...
         
         or 嵌套事务 需 数据库支持保存点
         $db->transaction(function ($db) {
            // inner transaction
         });

       }, $isolationLevel );
     */
    public function actionTransaction()
    {
        $isolationLevel = \yii\db\Transaction::REPEATABLE_READ;  //可重载默认的隔离级别
        $db = yii::$app->db;
        $transaction = $db->beginTransaction($isolationLevel);
        
        try {
            $result = $db->createCommand('UPDATE {{%country}} SET population=population+20000 WHERE [[code]] = :code')
            ->bindValue(':code', 'GT')->execute();
            
//             $result = $db->createCommand()->insert('{{country}}', [
//                 'code' => 'GT',
//                 'name' => 'test',
//                 'population' => '111000',
//             ])->execute();
            
            #事务嵌套
            $innerTransaction = $db->beginTransaction();
            try {
                $result = $db->createCommand('UPDATE {{%country}} SET population=population+20000 WHERE [[code]] = :code')
                ->bindValue(':code', 'GT')->execute();
                
                $result = $db->createCommand()->insert('{{%country}}', [
                     'code' => 'GT',
                     'name' => 'test',
                     'population' => '111000',
                ])->execute();
                
                $innerTransaction->commit();
            } catch (\Exception $e) {
                $innerTransaction->rollBack();
                throw $e;
            }
            
            $transaction->commit();
        }catch (\Exception $e) {
            
            $transaction->rollBack();
            throw $e;
        }
        
    }
    
}
