<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';

?>

<div>
    
    <?php $form = ActiveForm::begin([]); ?>
    
    <?= $form->field($model, 'login')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password2')->passwordInput() ?>
    
    <?= Html::submitButton('Зарегистрироваться') ?>
    
    <?php ActiveForm::end() ?>
    
</div>
