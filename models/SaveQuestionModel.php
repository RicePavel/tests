<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ar\Users;
use app\models\ar\Question;
use app\models\ar\Question_option;
use yii\db\Query;

class SaveQuestionModel extends Model {
    
    public $obj;
    public $question_id;
    
    function __construct($obj, $question_id) {
        parent::__construct();
        $this->obj = $obj;
        $this->question_id = $question_id;
    }
    
    public function saveQuestion() {
        $obj = $this->obj;
        $question_id = $this->question_id;
        $result = ['status' => false, 'error' => ''];
        if (!$obj->description || $obj->description === '') {
            $result['error'] = 'Введите текст вопроса';
            return $result;
        }
        if (!$obj->options || !is_array($obj->options)) {
            $result['error'] = 'Введите варианты ответов';
            return $result;
        }
        $options = array();
        foreach ($obj->options as $option) {
            if ($option->description) {
                $options[] = $option;
            }
        }
        $obj->options = $options;
        if (count($obj->options) == 0) {
            $result['error'] = 'Введите варианты ответов';
            return $result;
        }
        $existCorrect = false;
        $existNotCorrect = false;
        foreach ($obj->options as $option) {
            if ($option->is_correct) {
                $existCorrect = true;
            }
            if (!$option->is_correct) {
                $existNotCorrect = true;
            }
        }
        if (!$existCorrect) {
            $result['error'] = 'Выберите хотя бы один правильный ответ';
            return $result;
        }
        if (!$existNotCorrect) {
            $result['error'] = 'Все варианты не могут быть правильными';
            return $result;
        }
        $questionAr = Question::find()->with(['question_options'])->where(['question_id' => $question_id])->one();
        if (!$questionAr) {
            $result['error'] = 'Вопрос на найден';
            return $result;
        }
        $questionAr->description = $obj->description;
        $ok = $questionAr->save();
        if (!$ok) {
            $result['error'] = ModelUtils::getModelErrors($questionAr);
            return $result;
        }
        foreach ($questionAr->question_options as $optionAr) {
            $ok = $optionAr->delete();
            if (!$ok) {      
                $result['error'] = ModelUtils::getModelErrors($optionAr);
                return $result;
            }
        }
        $num = 1;
        foreach ($obj->options as $option) {
            $optionAr = new Question_option();
            $optionAr->question_id = $question_id;
            $optionAr->description = $option->description;
            $optionAr->is_correct = $option->is_correct;
            $optionAr->num = $num;
            $ok = $optionAr->save();
            if (!$ok) {
                $result['error'] = ModelUtils::getModelErrors($optionAr);
                return $result;
            }
            $num++;
        }
        $result['status'] = true;
        return $result;
    }
    
}

