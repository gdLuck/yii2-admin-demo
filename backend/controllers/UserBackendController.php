<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserBackend;
use backend\models\UserBackendSearch;
use backend\models\SignupForm;
use backend\models\AdminLog;
use backend\components\BackendHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * UserBackendController implements the CRUD actions for UserBackend model.
 */
class UserBackendController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserBackend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserBackendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserBackend model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     *  create new user
     */
    public function actionSignup ()
    {
        $model = new SignupForm();
        BackendHelper::attachAdminLogBehavior($model);
        // 如果是post提交且有对提交的数据校验成功（我们在SignupForm的signup方法进行了实现）
        // $model->load() 方法，把post过来的数据赋值给model
        // $model->signup() 方法, 要实现的具体的添加用户操作
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $model->modelLogRecord($model,AdminLog::ACTION_TYPE_SIGNUP);
            return $this->redirect(['index']);
        }
        
        // 渲染添加新用户的表单
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    // 看主要的验证操作，该操作是表单字段失去焦点时异步验证，同时如果直接提交表单，也会先执行该操作进行验证
    public function actionValidateSignupForm ($id = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //更新验证用，此处不适合
        #$model = $id === null ? new UserBackend() : UserBackend::findOne($id);
        $model = new SignupForm();
        $model->load(Yii::$app->request->post());
        return \yii\widgets\ActiveForm::validate($model);
    }
    
    /**
     * Creates a new UserBackend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserBackend();
        BackendHelper::attachAdminLogBehavior($model);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserBackend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserBackend model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (1 == $id){
            yii::$app->getSession()->setFlash('error','总管理员不可删除！');
            return Yii::$app->getResponse()->redirect('/user-backend/index');
        }
        
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserBackend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserBackend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBackend::findOne($id)) !== null) {
            BackendHelper::attachAdminLogBehavior($model);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
