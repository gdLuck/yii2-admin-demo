<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        "admin" => [
            "class" => 'mdm\admin\Module',#引用的是下面定义的别名 yii2-admin/rbac配置
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\UserBackend',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'response' => [
            'class' => 'yii\web\Response',
//             'on beforeSend' => function ($event) {
//                 $response = $event->sender;
//                 if ($response->data !== null) {
//                     $response->data = [
//                         'success' => $response->isSuccessful,
//                         'data' => $response->data,
//                     ];
//                     $response->statusCode = 200;
//                 }
//             },
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,  #调试时堆栈3层，否则没有调用堆栈信息被包含
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logVars' => ['_GET'], #追加一些上下文信息  默认为 _SERVER 可不设置
                    'levels' => ['error', 'warning'],
                    #'flushInterval' => 100,   // default is 1000  刷新(执行有问题，待修改)
                    #'exportInterval' => 100,  // default is 1000  导出（日志目标累积了一定数量的过滤消息的时候才会发生）
                    'except' => [#黑名单
                        'yii\web\HttpException:404',
                    ],
                    'prefix' => function ($message) {#自定义消息前缀
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID]";
                    }
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],#可设置 'error', 'warning', 'info', 'trace' 'profile'( Yii::beginProfile() 和 Yii::endProfile())
                    'categories' => [#白名单
                        'yii\db\*',
                        'yii\web\HttpException:*',
                    ],
                    'except' => [#黑名单
                        'yii\web\HttpException:404',
                    ],
                ],
//                 [
//                     'class' => 'yii\log\EmailTarget',
//                     'levels' => ['error'],
//                     'categories' => ['yii\db\*'],
//                     'message' => [
//                         'from' => ['log@example.com'],
//                         'to' => ['admin@example.com', 'developer@example.com'],
//                         'subject' => 'Database errors at example.com',
//                     ],
//                 ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            #'errorView' => '', //可以配置错误处理器的 errorView 和 exceptionView 属性 使用自定义的错误显示视图。
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        #amdinlte 样式修改控制
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
        ],
    ],
    //as access位置在components外！！！ yii2-admin/rbac
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //这里是允许访问的action
            'site/captcha',
            //'*'  #初始测试用
        ]
    ],
    'params' => $params,
];
