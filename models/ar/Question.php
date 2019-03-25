<?php

namespace app\models\ar;

use yii\db\ActiveRecord;

class Question extends ActiveRecord {
    
    public function getTest() {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }
    
    public function getQuestion_options() {
        return $this->hasMany(Question_option::className(), ['question_id' => 'question_id']);
    }
    
}

