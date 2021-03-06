<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-backend',
    'name' => '后台管理系统',
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
    'charset'=>'utf-8',
    'defaultRoute'=>'site',//指定未配置的请求的响应 路由 规则
    
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    
    'bootstrap' => ['log'],

    'modules' => [
        "admin" => [
            "class" => 'mdm\admin\Module',#引用别名  用于yii2-admin/rbac配置
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
        //添加 模版引擎配置
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'Url' => ['class' => '\yii\helpers\Url'],
                        'Html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            #'errorView' => '', //可以配置错误处理器的 errorView 和 exceptionView 属性 使用自定义的错误显示视图。
        ],
        'urlManager' => [
            //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，
            // Yii2.0中改称美化。
            // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。
            "enablePrettyUrl" => true,
            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
            // 否则认为是无效路由。
            // 这个选项仅在 enablePrettyUrl 启用后才有效。
            "enableStrictParsing" => false,
            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
            "showScriptName" => false,
            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
            "suffix" => "",
            "rules" => [
                "<controller:\w+>/<id:\d+>"=>"<controller>/view",
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"
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
            //这里是允许访问的action //控制器内优先级高于此处
            'site/captcha',
            'site/logout',
            'site/login',
            'site/formatter-test'
            //'*'  #初始测试用
        ]
    ],
    'params' => $params,
];
