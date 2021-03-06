<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ar\Users;
use app\models\ar\Question;
use app\models\ar\Question_option;
use yii\db\Query;

class AddQuestionModel extends Model {
    
    public $obj;
    public $test_id;
    
    function __construct($obj, $test_id) {
        parent::__construct();
        $this->obj = $obj;
        $this->test_id = $test_id;
    }
    
    public function addQuestion() {
        $obj = $this->obj;
        $test_id = $this->test_id;
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
        $max = (new Query())->select(['num'])->from('question')->max('num');
        if (!$max) {
            $max = 0;
        }
        $num = $max + 1;
        $questionAr = new Question();
        $questionAr->test_id = $test_id;
        $questionAr->description = $obj->description;
        $questionAr->num = $num;
        $ok = $questionAr->save();
        if (!$ok) {
            $result['error'] = ModelUtils::getModelErrors($questionAr);
            return $result;
        }
        $question_id = $questionAr->question_id;
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

