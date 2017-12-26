<?php
/*
 * 日期选择器
 */
namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 *
 */
class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@common/extensions';
    public $js = [
        'My97DatePicker/WdatePicker.js'
    ];
}
