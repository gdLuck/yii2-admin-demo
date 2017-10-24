<?php
/**
 * 常用功能
 */
namespace common\components;

use yii;

class Helper
{
    /**
     * 图片地址转换
     * @param string $imgPath 图片地址
     * @return string
     */
    public static function imageUrlConvert($imgPath, $absoluteUrl=false)
    {
        if(empty($imgPath)) return '';
        if($absoluteUrl){
            return  Yii::$app->params['cdnUrl'].Yii::$app->params['uploadPath'].$imgPath;
        }else{
            return  '/'.Yii::$app->params['uploadPath'].$imgPath;
        }
    }
}