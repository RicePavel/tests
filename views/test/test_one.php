<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?php 

 if (\Yii::$app->session->hasFlash('error')) {
     echo \Yii::$app->session->getFlash('error');
 }
?>

<?= Html::encode($model->name) ?>

<?php $changeForm = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['/test/test_change', 'test_id' => $model->test_id])]); ?>
    <?= Html::submitButton('Изменить') ?>
<?php ActiveForm::end() ?>

<?php $deleteForm = ActiveForm::begin(['action' => Url::to(['/test/test_delete'])]); ?>
    <?= $deleteForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Удалить') ?>
<?php ActiveForm::end() ?>

<?php $addQuestionForm = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['/test/add_question', 'test_id' => $model->test_id])]); ?>
    <?= Html::submitButton('Добавить вопрос') ?>
<?php ActiveForm::end() ?>

<?php foreach ($model->sorted_questions as $question) { ?>

<div>
    <div><?= $question->description ?>
    <a href="<?= Url::to(['/test/change_question', 'question_id' => $question->question_id, 'test_id' => $model->test_id]) ?>">Изменить</a>
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/delete_question']), 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button href="#">Удалить</button>
    <?php ActiveForm::end() ?>
    
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/up_question']), 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button href="#">Вверх</button>
    <?php ActiveForm::end() ?>
       
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/down_question']), 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button href="#">Вниз</button>
    <?php ActiveForm::end() ?>
        
    </div>
    <ul>
    <?php foreach ($question->sorted_question_options as $option) { ?>
        <li><?= $option->description ?><?= ($option->is_correct ? ' (+)' : '') ?></li>
    <?php } ?>
    </ul>
</div>
    
<?php } ?>


