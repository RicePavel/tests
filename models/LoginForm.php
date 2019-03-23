<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ar\Users;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = Users::findOne(['login' => $this->username]);
            if ($user && $this->checkLoginData($user->password)) { 
                return Yii::$app->user->login($user);
            } else {
                $this->addError('username', 'Не найден пользователь с таким логином и паролем!');
            }
        }
        return false;
    }
    
    private function checkLoginData($passwordHash) {
        return \Yii::$app->getSecurity()->validatePassword($this->password, $passwordHash);
    }
    
    /*
    private function checkLoginData() {
        $user = Users::findOne(['login' => $this->username]);
        if ($user) {
            $password = $user->password;
            return \Yii::$app->getSecurity()->validatePassword($this->password, $password);
        }
    }
     */

}
