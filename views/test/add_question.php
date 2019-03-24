<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Добавить вопрос';

?>

<form id="add_question_form">
    Текст вопроса: <br/>
    <textarea name="description" placeholder="Введите текст вопроса..."></textarea><br/>
    <input id="add_option_submit" type="submit" value="Добавить вариант ответа" /><br/>
    
</form>

<p>Варианты ответа:</p>
<div id="options">
    
</div>

<br/>
<br/>
<input id="save_submit" type="submit" value="Сохранить" />
