<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        
        //authManager有PhpManager和DbManager两种方式,
        //PhpManager将权限关系保存在文件里,这里使用的是DbManager方式,将权限关系保存在数据库.
        "authManager" => [
            "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号
            "defaultRoles" => ["guest"],
        ],
        'cache' => [
            'class' => 'common\components\Cache',
            'keyPrefix'   => 'yii:vrpeng:datacache:',
            'redis' => [
                'hostname' => '',
                'password' => '',#本地配置会覆盖线上配置
                'port' => 6379,
                'database' => 0,
            ]
        ],
        'file_cache' => [
            'class' => 'yii\caching\FileCache',
            //'keyPrefix' => 'fileCache_vrpeng:',
            'directoryLevel' => 2,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '',
            'password' => '',#本地配置会覆盖线上配置
            'port' => 6379,
            'database' => 0,
        ],
    ],
];
