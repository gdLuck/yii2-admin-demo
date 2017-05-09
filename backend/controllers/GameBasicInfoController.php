<?php

namespace backend\controllers;

use Yii;
use backend\models\GameBasicInfo;
use backend\models\GameBasicInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use backend\components\BackendHelper;
use backend\components\Pinyin;

/**
 * GameBasicInfoController implements the CRUD actions for GameBasicInfo model.
 */
class GameBasicInfoController extends Controller
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'upload'=>[
                'class' => '\common\widgets\file_upload\UploadAction',  //扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/game/{yyyy}{mm}{dd}/{time}{rand:6}",
                    'imageMaxSize' => '1000000', //限制1M
                    'uploadPath' => yii::$app->params['uploadPath'],
                ]
            ]
        ];
    }
    
    /**
     * Lists all GameBasicInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GameBasicInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GameBasicInfo model.
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
     * Creates a new GameBasicInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GameBasicInfo();
        $model->loadDefaultValues();
        BackendHelper::attachAdminLogBehavior($model);
        
        if (yii::$app->getRequest()->post('GameBasicInfo')){
            /* 处理分类信息 */
            if (is_array($_POST['GameBasicInfo']['type_terrace'])){
                $_POST['GameBasicInfo']['type_terrace'] = implode(',', $_POST['GameBasicInfo']['type_terrace']);
            }
            if (is_array($_POST['GameBasicInfo']['type_content'])){
                $_POST['GameBasicInfo']['type_content'] = implode(',', $_POST['GameBasicInfo']['type_content']);
            }
            if (is_array($_POST['GameBasicInfo']['type_people'])){
                $_POST['GameBasicInfo']['type_people'] = implode(',', $_POST['GameBasicInfo']['type_people']);
            }
            if (is_array($_POST['GameBasicInfo']['type_language'])){
                $_POST['GameBasicInfo']['type_language'] = implode(',', $_POST['GameBasicInfo']['type_language']);
            }
            $model->attributes = $_POST['GameBasicInfo'];
            //拼音简写
            $pyObj      = new Pinyin();
            $gameNameSpell = $pyObj->stringToPinyin($model->game_en_name, true);
            $model->game_name_spell = $pyObj->getGameSpell($gameNameSpell);
            $model->add_time = time();
            //VarDumper::dump($model);exit;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->game_id]);
            }else{
                VarDumper::dump($model->errors);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GameBasicInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->game_id]);
        } else {
            
            /* 处理分类信息 */
            $model->type_terrace = explode(',', $model->type_terrace);
            $model->type_content = explode(',', $model->type_content);
            $model->type_people  = explode(',', $model->type_people);
            $model->type_language = explode(',', $model->type_language);
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GameBasicInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * AJAX验证
     */
    public function actionAjaxVerification(){
        $model = new GameBasicInfo();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return  \yii\widgets\ActiveForm::validate($model);
        }
        // 看主要的验证操作，该操作是表单字段失去焦点时异步验证，同时如果直接提交表单，也会先执行该操作进行验证
//         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//         $model = new Model();   //这里要替换成自己的模型类
//         $model->load(Yii::$app->request->post());
//         return \yii\widgets\ActiveForm::validate($model);
    }
    
    /**
     * Finds the GameBasicInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GameBasicInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GameBasicInfo::findOne($id)) !== null) {
            BackendHelper::attachAdminLogBehavior($model);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
