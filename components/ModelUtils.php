<?php

namespace app\components;

use yii\db\ActiveRecord;

class ModelUtils {
    
    public static function getModelErrors($activeRecord) {
        $errorStr = '';
        $errors = $activeRecord->errors;
        $i = 0;
        $j = 0;
        foreach ($errors as $arr) {
            foreach ($arr as $val) {
                $errorStr .= ($i === 0 && $j === 0 ? '' : ', ');
                $errorStr .= $val;
                $j++;
            }
            $i++;
        }
        return $errorStr;
    }
    
}
