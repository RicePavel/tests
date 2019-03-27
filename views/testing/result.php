<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<p>Правильных ответов: <?= $countRight ?></p>
<p>Неправильных ответов: <?= $countNotRight ?></p>
<p>Процент правильных ответов: <?= $percentRight ?>%</p>

<br/>
<p>Ваши ответы:<p/>
<br/>

<div>
    
    <?php foreach ($testModel->sorted_questions as $question) { ?>
    <div><?= Html::encode($question->description) ?></div>
        <?php foreach ($question->sorted_question_options as $option) { ?>
            <?php 
                $cl = '';
                if ($option->is_correct) {
                    $cl .= 'correct_answer ';
                }
                if (in_array($option->question_option_id, $answers[$question->question_id])) {
                    if (!$option->is_correct) {
                        $cl .= 'incorrect_answer ';
                    }
                }
            ?>
    
            <li class="<?= $cl ?>"><?= Html::encode($option->description) ?></li>
        <?php } ?>
    <?php } ?>
    
</div>