<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ar\Users;

class RegistrationForm extends Model {
    
    public $login;
    public $password;
    public $password2;
    
    public function rules() {
        return  [
                [['login', 'password', 'password2'], 'required'],
                [['login', 'password', 'password2'], 'safe'],
                ['password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
                //[['login'], 'checkLogin'],
                [['login', 'password', 'password2'], 'string', 'length' => [4, 255]],
                [['login'], 'email']
            ];
    }
    
    public function attributeLabels() {
        return [
                'login' => 'Логин',
                'password' => 'Пароль',
                'password2' => 'Пароль еще раз'
            ];
    }
    
    public function checkLogin($attribute, $params) {
        $users = Users::find()->where(['login' => $this->login])->all();
        if (count($users) > 0) {
            $this->addError($attribute, 'Такой логин уже существует');
        }
    }
    
    public function registration() {
        if ($this->validate()) {
            $user = new Users();
            $user->attributes = $this->attributes;
            $password = $this->password;
            $hash = \Yii::$app->getSecurity()->generatePasswordHash($password);
            $user->password = $hash;
            if ($user->validate()) {
                $ok = $user->save();
                if ($ok) {
                    return true;
                } else {
                    $this->addErrors($user->getErrors());
                }
            } else {
                $this->addErrors($user->getErrors());
            }
        }
        return false;
    }
    
}

