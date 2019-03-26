<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\ar\Test;
use app\models\ar\Question;
use app\components\Questions;

class TestingController extends Controller {
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['tests', 'test_start', 'test_next'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['tests', 'test_start', 'test_next'],
                        'roles' => ['@']
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
    
    public function actionTests() {
        $testArray = Test::getAll();
        $model = new Test();
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())
                && $model->save()) {
            return $this->redirect(['/testing/tests']);
        }
        return $this->render('tests', ['testArray' => $testArray, 'model' => $model]);
    }
    
    public function actionTest_start($test_id) {
        $model = Test::find()->with(['sorted_questions', 'sorted_questions.sorted_question_options'])->where(['test_id' => $test_id])->one();
        $session = \Yii::$app->session;
        $question = null;
        $error = '';
        if ($model) {
            $session->set('test_' . $test_id, $model);
            $question = $this->getNextQuestion($model);
            if ($question) {
                $session->set('current_question_' . $test_id, $question);
                $session->set('right_count_' . $test_id, 0);
            } else {
                $error = 'В этом тесте нет вопросов';
            }
        } else {
            $error = 'Тест не найден!';
        }
        return $this->render('question', ['error' => $error, 'question' => $question, 'test_id' => $test_id]);
    }

    public function actionTest_next() {
        $post = \Yii::$app->request->post();
        $session = \Yii::$app->session;
        $test_id = $post['test_id'];
        $options = $post['options'];
        $question_id = $post['question_id'];
        if ($test_id) {
            $testModel = $session->get('test_' . $test_id);
            $question = $session->get('current_question_' . $test_id);
            $right_count = $session->get('right_count_' . $test_id);
            if ($testModel !== null && $question !== null && $right_count !== null) {
                if ($question->question_id === (int) $question_id) {
                    if ($options) {
                        $isRight = $this->isRight($question, $options);
                        if ($isRight) {
                            $right_count++;
                            $session->set('right_count_' . $test_id, $right_count);
                        }
                        $nextQuestion = $this->getNextQuestion($testModel, $question->num);
                        if ($nextQuestion) {
                            $session->set('current_question_' . $test_id, $nextQuestion);
                            $session->set('right_count_' . $test_id, $right_count);
                            return $this->render('question', ['question' => $nextQuestion, 'test_id' => $test_id]);
                        } else {
                            $session->remove('test_' . $test_id);
                            $session->remove('current_question_' . $test_id);
                            $session->remove('right_count_' . $test_id);
                            $countAll = count($testModel->sorted_questions);
                            $countNotRight = 0;
                            $percentRight = 0;
                            if ($countAll !== 0) {
                                $countNotRight = $countAll - $right_count;
                                $percentRight = round(($right_count/$countAll)*100);
                            }
                            return $this->render('result', 
                                    ['countRight' => $right_count, 'countNotRight' => $countNotRight, 'percentRight' => $percentRight]);
                        }
                    } else {
                        $error = 'Выберите вариант ответа';
                        return $this->render('question', ['error' => $error, 'question' => $question, 'test_id' => $test_id]);
                    }
                } else {
                    return $this->render('question', ['error' => $error, 'question' => $question, 'test_id' => $test_id]);
                }
            } else {
                $this->redirect(['/testing/test_start', 'test_id' => $test_id]);
            }
        } else {
            $this->redirect(['/testing/tests']);
        }
    }
    
    private function getNextQuestion($testModel, $currentQuestionNum = 0) {
        $question = null;
        foreach ($testModel->sorted_questions as $q) {
            if ($q->num > $currentQuestionNum) {
                return $q;
            }
        }
        return $question;
    }
    
    private function isRight($question, $options) {
        foreach ($question->sorted_question_options as $optionsModel) {
            $id = $optionsModel->question_option_id;
            if ($optionsModel->is_correct) {
                if (!in_array($id, $options)) {
                    return false;
                }
            } else {
                if (in_array($id, $options)) {
                    return false;
                }
            }
        }
        return true;
    }
    
}

