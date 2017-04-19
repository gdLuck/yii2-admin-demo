<?php
/**
 * 扩展 redis 使用测试
 */
namespace api\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\VarDumper;

class RedisTestController extends Controller
{
    public function actionIndex()
    {
        $redis = yii::$app->redis;
        
        #$redis->flushall();#删除所有缓存; ！！！慎 用！！！
        #$redis->flushdb();#删除当前数据库   两个redisID名重复 也会清除错误
        
        //$result = $redis->ping();
        
        $key = $this->setKey('key1');
        $key1 = $this->setKey('key2');
        
        if (!$redis->exists($key)){
            echo 'set'."<br/>";
            $redis->set($key, 'value1');
            
        }
        $result[] = $redis->get($key);
        
        $result[] = $redis->keys('*');
        
        VarDumper::dump($result);
    }

    /**
     * 可移至helper 待整合
     * @param string $key
     */
    private function setKey($key)
    {
        return yii::$app->params['redisPrefix'].$key;
    }
}