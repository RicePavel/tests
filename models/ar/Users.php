<?php

namespace app\models\ar;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{
    
    public function rules() {
        return [
            [['login', 'password'], 'required'],
            ['login', 'unique', 'message' => 'Такой логин уже существует'],
            [['login'], 'safe']
        ];
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function getAuthKey(): string {
        return $this->auth_key;
    }

    public function getId() {
        return $this->user_id;
    }

    public function validateAuthKey($authKey): bool {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface {
        throw new Exception();
    }

}

