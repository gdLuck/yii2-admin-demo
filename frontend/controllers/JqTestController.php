<?php
namespace frontend\controllers;

use yii;

class JqTestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    
    public function actionAjaxCallback()
    {
        //跨域方法一
        //$headers = Yii::$app->response->headers;
        //$headers->add('Access-Control-Allow-Origin', '*');
        
        //跨域调用方法二 jsonp
        $callback   = yii::$app->request->get('callback');
        
        if ($callback) {
			echo $callback.'('.json_encode(['data'=>'123']).')';exit;
		} else {
			echo json_encode(['data'=>'123']);
		}
    }
}
