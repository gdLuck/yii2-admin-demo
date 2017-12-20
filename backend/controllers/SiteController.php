<?php
/**
 * 后台首页
 * adminlte 详细样式位置：
 * /vendor/almasaeed2010/adminlte/index.html 
 */
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\PageCache;
use yii\filters\Cors;
use yii\caching\DbDependency;
use backend\models\LoginForm;
use backend\models\AdminLog;
use backend\components\BackendHelper;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://www.vrpeng.com'], #定义允许来源数组
                    #'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],  #允许动作数组
                    #'Access-Control-Request-Headers' =>['*'],  #允许请求头部数组     例 ['X-Request-With'] 指定类型头部
                    #'Access-Control-Allow-Credentials' => null,  #定义当前请求是否使用证书
                    #'Access-Control-Max-Age' => 86400,  #定义请求的有效时间
                ],
                'actions' => [
                    'login' => [
                        'Access-Control-Allow-Credentials' => false, // 表示是否可以将对请求的响应暴露给页面。
                    ]
                ]
            ],
            'access' => [
                'class' => AccessControl::className(), #权限
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha', 'formatter-test'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                        #'ips' => ['127.0.0.1'],
                        //'matchCallback' => function ($rule, $action) {
                        //    return date('Y-m-d') === '2017-5-1';  #设置规则只有5月1日可访问此
                        //}
                    ],
                ],
            ],
//            'pageCache' => [
//                'class' => PageCache::className(),#页面缓存
//                'only' => ['index'],
//                'duration' => 60,
//                //                 'dependency' => [
//                    //                     #'class' => DbDependency::className(),
//                    //                     #'sql' => 'SELECT COUNT(*) FROM post',
//                    //                 ],
//                'variations' => [
//                    \Yii::$app->language,
//                ]
//            ],
            'verbs' => [
                'class' => VerbFilter::className(), #检查请求动作的HTTP请求方式是否允许执行
                'actions' => [
                    'logout' => ['post'],
                    #'index'  => ['get'],
                    #'view'   => ['get'],
                    #'create' => ['get', 'post'],
                    #'update' => ['get', 'put', 'post'],
                    #'delete' => ['post', 'delete'],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        #Yii::$app->getSession()->setFlash('success', '<b>成功!</b> ');
        #Yii::$app->getSession()->setFlash('warning', '<b>警告!</b> ');
        #Yii::$app->getSession()->setFlash('error', ['Error 1', 'Error 2']);  #多个错误时
        
        $data['serverSoft'] = $_SERVER['SERVER_SOFTWARE'];
        $data['serverOs']   = PHP_OS;
        $data['phpVersion'] = PHP_VERSION;
        $data['fileupload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : '禁止上传';
        $data['serverUri']  = $_SERVER['SERVER_NAME'];
        $data['maxExcuteTime']   = ini_get('max_execution_time') . ' 秒';
        $data['maxExcuteMemory'] = ini_get('memory_limit');
        $data['allow_url_fopen'] = ini_get('allow_url_fopen') ? '开启' : '关闭';
        $data['excuteUseMemory'] = function_exists('memory_get_usage') ? BackendHelper::fileSizeBKM(memory_get_usage()) : '未知';
//         $dbsize = 0;
//         $connection = yii::$app->db;
//         $sql = 'SHOW TABLE STATUS LIKE \'' . $connection->tablePrefix . '%\'';
//         $command = $connection->createCommand($sql)->queryAll();
//         foreach ($command as $table){
//             $dbsize += $table['Data_length'] + $table['Index_length'];
//         }
//         $mysqlVersion = $connection->createCommand("SELECT version() AS version")->queryAll();
//         $data['mysqlVersion'] = $mysqlVersion[0]['version'];
//         $data['dbsize'] = $dbsize ? BackendHelper::fileSizeBKM($dbsize) : '未知';
        
        return $this->render('index',[
            'server' => $data,
        ]);
    }
    
    /**
     * 格式化输出测试
     */
    public function actionFormatterTest()
    {
        $formatter = yii::$app->formatter;
        // output: January 1, 2014
        echo $formatter->asDate('2014-01-01', 'long').PHP_EOL;
        
        // output: 12.50%
        echo $formatter->asPercent(0.125, 2).PHP_EOL;
        
        // output: <a href="mailto:cebe@example.com">cebe@example.com</a>
        echo $formatter->asEmail('cebe@example.com').PHP_EOL;
        
        // output: Yes
        echo $formatter->asBoolean(true).PHP_EOL;
        // it also handles display of null values:
        
        // output: (Not set)
        echo $formatter->asDate(null).PHP_EOL;
        
        // output: January 1, 2014
        echo Yii::$app->formatter->format('2014-01-01', 'date').PHP_EOL;
        
        // 你可以在第二个参数指定一个数组，这个数组提供了一些配置的参数
        // 例如这个 2 就是 asPercent() 方法的 $decimals 参数
        // output: 12.50%
        echo Yii::$app->formatter->format(0.125, ['percent', 2]).PHP_EOL;
        // ICU format
        echo Yii::$app->formatter->asDate('now', 'yyyy-MM-dd').PHP_EOL;// 2014-10-06
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // 判断用户是访客还是认证用户
        // isGuest为真表示访客，isGuest非真表示认证用户，认证过的用户表示已经登录了，这里跳转到主页面
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        // 实例化登录模型 backend\models\LoginForm
        $model = new LoginForm();
        //添加日志行为 
        BackendHelper::attachAdminLogBehavior($model);
        // 接收表单数据并调用LoginForm的login方法
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $model->modelLogRecord($model, AdminLog::ACTION_TYPE_LOGIN);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
