<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\ar\Test;
use app\components\Questions;

class TestController extends Controller {
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['tests', 'test_one', 'test_change', 'change_question', 'get_question', 'delete_question', 'up_question', 'down_question', 'add_question'],
                'rules' => [
                    [
                        'actions' => ['tests', 'test_one', 'test_change', 'change_question', 'get_question', 'delete_question', 'up_question', 'down_question', 'add_question'],
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
        $model = Test::find()->with(['questions', 'questions.question_options'])->where(['test_id' => $test_id])->one();
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
    
    public function actionChange_question($question_id) {
        return $this->render('change_question', ['question_id' => $question_id]);
    }
    
    public function actionGet_question() {
        
    }
    
    public function actionDelete_question() {
        
    }
    
    public function actionUp_question() {
        
    }
    
    public function actionDown_question() {
        
    }
    
    public function actionAdd_question() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $obj = json_decode($post['question']);
            $test_id = $post['test_id'];
            $result = Questions::saveQuestion($obj, $test_id);
            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $result;
        } else {
            $test_id = \Yii::$app->request->get()['test_id'];
            return $this->render('add_question', ['test_id' => $test_id]);
        }
    }
    
    
    
}

