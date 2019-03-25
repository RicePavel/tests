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

<?php foreach ($model->questions as $question) { ?>

<div>
    <div><?= $question->description ?>
    <a href="<?= Url::to(['/test/change_question', 'question_id' => $question->question_id]) ?>">Изменить</a>&nbsp;<a href="#">Удалить</a>&nbsp;<a href="#">Вверх</a>&nbsp;<a href="#">Вниз</a>
    </div>
    <ul>
    <?php foreach ($question->question_options as $option) { ?>
        <li><?= $option->description ?><?= ($option->is_correct ? ' (+)' : '') ?></li>
    <?php } ?>
    </ul>
</div>
    
<?php } ?>


