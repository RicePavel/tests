<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\assets\ChangeQuestionAsset;

ChangeQuestionAsset::register($this);
$this->title = 'Изменить вопрос';

?>

<form id="change_question_form">
    Текст вопроса: <br/>
    <textarea name="description" placeholder="Введите текст вопроса..." id="description_area"></textarea><br/>
    <input type="hidden" name="question_id" value="<?= $question_id ?>" id="question_id" />
    <input type="hidden" name="test_id" value="<?= $test_id ?>" id="test_id" />
    <input id="add_option_submit" type="submit" value="Добавить вариант ответа" /><br/>
    
    
</form>

<p>Варианты ответа:</p>
<div id="options">
    
</div>

<br/>
<br/>
<input id="save_submit" type="submit" value="Сохранить" />
