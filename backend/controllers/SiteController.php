<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\AdminLog;

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
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','captcha'],
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
                'class' => 'yii\captcha\captchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ] 
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
        // 接收表单数据并调用LoginForm的login方法
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            yii::$app->adminLogRecord($model,AdminLog::ACTION_TYPE_LOGIN);
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
