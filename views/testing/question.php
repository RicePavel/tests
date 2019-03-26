<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?php 

if ($error) {
    echo '<p>' . $error . '</p>';
}

?>

<?php if ($question) { ?>
    
    <?= $question->description ?>
    
    <?php $form = ActiveForm::begin(['action' => Url::to(['/testing/test_next'])]); ?>
        <input type="hidden" name="test_id" value="<?= $test_id ?>" />
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <?php foreach ($question->sorted_question_options as $option) { ?>
            <div>
                <input value="<?= $option->question_option_id ?>" name="options[]" type="checkbox" />
                <?= $option->description ?>
            </div>
        <?php } ?>
        <input type="submit" value="Ответить"  />
    <?php Activeform::end() ?>

<?php } ?>

