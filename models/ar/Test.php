<?php

namespace app\models\ar;

use yii\db\ActiveRecord;

class Test extends ActiveRecord {
    
    public function attributeLabels() {
        return [
            'name' => 'Заголовок'
        ];
    }
    
    public static function getAll() {
        return static::find()->all();
    }
    
    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'length' => [1, 500]]
        ];
    }
    
    public function getQuestions() {
        return $this->hasMany(Question::className(), ['test_id' => 'test_id']);
    }
    
}

