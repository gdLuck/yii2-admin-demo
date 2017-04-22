<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2blog',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'vrbox_',
            #'enableSchemaCache' => true,#若数据库有变动要关闭更新以缓存
            #'schemaCacheDuration' => 24*3600,
            #'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //authManager有PhpManager和DbManager两种方式,
        //PhpManager将权限关系保存在文件里,这里使用的是DbManager方式,将权限关系保存在数据库.
        "authManager" => [
            "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号
            "defaultRoles" => ["guest"],
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
