<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    
    public $jsOptions = [
        'position'=>View::POS_HEAD #头部加载JS
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
