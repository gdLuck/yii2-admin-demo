<?php
namespace common\components;

use yii;

/**
 * 数据缓存机制
 * 在需要缓存的类方法前加 "_"  定义为 protected 方法, 需访问缓存数据时调用 不加前缀方法名使用
 * 各模型方法单独缓存时间设置：方法名 + _ + cachetime 
 */
abstract class CachePipe{

    /**
     * @var Object  The driver of data-caching.
     */
    private $_cacheObj;

    /**
     * @var bool    Wether to use data-caching.
     */
    public $caching = true;
    
    public $cachetime = 3600;

    public function __construct(){
        //Initialize the cache object.
        $this->_cacheObj = Yii::$app->cache;
    }

    /**
     * Intercept the methods of the object to implement caching mechanism.
     * @param $name     The method would be called.
     * @param $args     The args for the specified method.
     * @return mixed|null
     * @throws CException
     */
    public function __call($name, $args){
        $realMethod = "_{$name}";
        if(!method_exists($this, $realMethod)){
            throw new \Exception("method '{$name}' not found");
        }
        $cacheKeySuffix = $args;
        foreach($cacheKeySuffix as $key=> $value){
        	is_array($value)?asort($cacheKeySuffix[$key]):"";
        }
        $cacheKey = "cachepiping_class_".get_class($this)."_method_{$name}_args_".serialize($cacheKeySuffix);
        //echo $cacheKey;exit;
        if($data = $this->_getCache($cacheKey)){
            return $data;
        }
        //load raw data from specified method.
        $data = call_user_func_array(array($this, $realMethod), $args);

        //set cache.
        $cachetimeProperty = $name . '_' . 'cachetime';
        if(isset($this->{$cachetimeProperty})){
        	$this->cachetime = $this->{$cachetimeProperty};
        }
        $this->_cacheObj->set($cacheKey, $data, $this->cachetime);
        return $data;
    }

    private function _getCache($cacheKey){
        if(!$this->caching){
            return NULL;
        }
        return $this->_cacheObj->get($cacheKey);
    }
}