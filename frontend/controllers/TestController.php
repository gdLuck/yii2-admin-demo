<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Url;

class TestController extends Controller
{
    /**
     * redis/cache 测试 REDIS版本需大于2.66
     */
    public function actionRedisCache()
    {
        $cache = yii::$app->cache;
        // 将数据在缓存中保留 3 秒
        $cache->set('test', 'value', 3);
        //sleep(5);
        $data = $cache->get('test');
        if ($data === false) {
            echo '已过期，或者在缓存中找不到';
        }else{
            echo $data;
        }
        
        //$cache->flush();
    }
    
    public function actionRedis()
    {
        $redis = yii::$app->redis;
//         $redis->set('test111', 'value111');
//         $redis->expire('test111',10); #按秒
//         $redis->setex('test222',20,'value222'); #按秒过期
        $redis->psetex('test333',15000,'value333');#按毫秒过期
        echo $redis->get('test111');
        echo $redis->get('test222');
        echo $redis->get('test333');
        //$redis->flushdb();
    }
    
   /**
     * 路由测试
     */
    public function actionUrlCreateTest(){
        
        //注意to 和 toRoute的区别
        // 当前活动路由
        echo Url::to('');
        echo '<br/>';
        // 相同的控制器，不同的动作
        echo Url::toRoute('entry'); echo '<br/>';
        // 相同模块，不同控制器和动作
        echo Url::toRoute(['country/index', 'code' => 'AU', '#' => 'content']); echo '<br/>';
        // 绝对路由，不管是被哪个控制器调用
        echo Url::toRoute('/Country/index');  echo '<br/>';
        //  从别名中获取 URL
        yii::setAlias('@baidu', 'http://www.baidu.com/');
        echo url::to('@baidu'); echo '<br/>';
        echo url::to('/site/registration'); echo '<br/>';
        // 获取当前页的标准 URL
        echo Url::canonical(); echo '<br/>';
        // 获得 home 主页的 URL
        echo url::home(); echo '<br/>';
        
        echo Url::base(); echo '<br/>';
        
        // 相同模块，不同控制器和动作 to
        echo Url::to(['country/index', 'code' => 'AU', '#' => 'content'], true); echo '<br/>';
        // an absolute URL: http://example.com/images/logo.gif
        echo Url::to('/css/site.css', true); echo '<br/>';//http://test.yii2.basic.com/css/site.css
        
        Url::remember() ; //  保存URL以供下次使用
        echo Url::previous(); // 取出前面保存的 URL
    }
}