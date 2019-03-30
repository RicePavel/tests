<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ar\Users;
use app\models\ar\Question;
use app\models\ar\Question_option;
use yii\db\Query;

class MoveQuestionModel extends Model {
    
    public $question_id;
    
    function __construct($question_id) {
        parent::__construct();
        $this->question_id = $question_id;
    }
    
     public function questionUp() {
        $question_id = $this->question_id;
        $result = ['status' => true, 'error' => ''];
        $question = Question::findOne($question_id);
        if (!$question) {
            $result['error'] = 'Вопрос на найден';
            return $result;
        }
        $test_id = $question->test_id;
        $num = $question->num;
        $row = \Yii::$app->db->createCommand('select question_id from question where test_id = :test_id and num = (select max(num) from question where test_id = :test_id and num < :num)')
                ->bindValue(':test_id', $test_id)->bindValue(':num', $num)->queryOne();
        if ($row) {
            $question_2 = Question::findOne($row['question_id']);
            if (!$question) {
                $result['error'] = 'Вопрос на найден';
                return $result;
            }
            $num_2 = $question_2->num;
            $question->num = $num_2;
            $question_2->num = $num;
            if ($question->save() && $question_2->save()) {
                $result['status'] = true;
                return $result;
            } else {
                $result['error'] = ModelUtils::getModelErrors($question) . 
                        ModelUtils::getModelErrors($question_2);
                return $result;
            }
        }
        return $result;
    }
    
    public function questionDown() {
        $question_id = $this->question_id;
        $result = ['status' => true, 'error' => ''];
        $question = Question::findOne($question_id);
        if (!$question) {
            $result['error'] = 'Вопрос на найден';
            return $result;
        }
        $test_id = $question->test_id;
        $num = $question->num;
        $row = \Yii::$app->db->createCommand('select question_id from question where test_id = :test_id and num = (select min(num) from question where test_id = :test_id and num > :num)')
                ->bindValue(':test_id', $test_id)->bindValue(':num', $num)->queryOne();
        if ($row) {
            $question_2 = Question::findOne($row['question_id']);
            if (!$question) {
                $result['error'] = 'Вопрос на найден';
                return $result;
            }
            $num_2 = $question_2->num;
            $question->num = $num_2;
            $question_2->num = $num;
            if ($question->save() && $question_2->save()) {
                $result['status'] = true;
                return $result;
            } else {
                $result['error'] = ModelUtils::getModelErrors($question) . 
                        ModelUtils::getModelErrors($question_2);
                return $result;
            }
        }
        return $result;
    }
    
}

