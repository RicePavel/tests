<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\ar\Test;

class TestController extends Controller {
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['tests', 'test_one', 'test_change'],
                'rules' => [
                    [
                        'actions' => ['tests', 'test_one', 'test_change'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            return $this->checkAdmin();
                        }
                    ]
                ]
            ]
        ];
    }
    
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }
    
    public function checkAdmin() {
        return \Yii::$app->user->getIdentity()->is_admin;
    }
    
    public function actionTests() {
        $testArray = Test::getAll();
        $model = new Test();
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())
                && $model->save()) {
            return $this->redirect(['/test/tests']);
        }
        return $this->render('tests', ['testArray' => $testArray, 'model' => $model]);
    }
    
    public function actionTest_one($test_id) {
        $model = Test::findOne($test_id);
        return $this->render('test_one', ['model' => $model]);
    }
    
    public function actionTest_change($test_id) {
        $model = Test::findOne($test_id);
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/test/test_one', 'test_id' => $test_id]);
        }
        return $this->render('test_change', ['model' => $model]);
    }
    
    public function actionTest_delete() {
        $model = new Test();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $test_id = (int) $post['Test']['test_id'];
            $model = Test::findOne($test_id);
            if ($model && $model->delete()) {
                return $this->redirect(['/test/tests']);
            }
        }
        \Yii::$app->session->addFlash('error', 'Не удалось удалить. ');
        return $this->redirect(['/test/test_one', 'test_id' => $model->test_id]);
    }
    
    public function actionAdd_question() {
        return $this->render('add_question');
    }
    
}

