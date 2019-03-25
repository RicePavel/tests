<?php

namespace app\models\ar;

use yii\db\ActiveRecord;

class Question extends ActiveRecord {
    
    public function fields() {
        $fields = parent::fields();
        $fields[] = 'question_options';
        return $fields;
    }
    
    public function getTest() {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }
    
    public function getQuestion_options() {
        return $this->hasMany(Question_option::className(), ['question_id' => 'question_id']);
    }
    
    public function getSorted_question_options() {
        return $this->hasMany(Question_option::className(), ['question_id' => 'question_id'])->orderBy(['question_option.num' => SORT_ASC]);
    }
    
}

