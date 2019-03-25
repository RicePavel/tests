<?php

namespace app\models\ar;

use yii\db\ActiveRecord;

class Question_option extends ActiveRecord {
    
    public function getQuestion() {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
    }
    
}

