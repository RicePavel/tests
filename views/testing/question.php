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
    
    <div class="question_description"><?= Html::encode($question->description) ?></div>
    
    <?php $form = ActiveForm::begin(['action' => Url::to(['/testing/test_next'])]); ?>
        <input type="hidden" name="test_id" value="<?= $test_id ?>" />
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
            <?php foreach ($question->sorted_question_options as $option) { ?>
                <div >
                    <input class="form-check-input" id="<?= $option->question_option_id ?>" value="<?= $option->question_option_id ?>" name="options[]" type="checkbox" />
                    <label class="" for="<?= $option->question_option_id ?>"><?= Html::encode($option->description) ?></label>
                </div>
            <?php } ?>
        <input  type="submit" value="Ответить" class="question_button btn btn-primary" />
    <?php Activeform::end() ?>

<?php } ?>

