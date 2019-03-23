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

<?php $changeForm = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['/admin/test_change', 'test_id' => $model->test_id])]); ?>
    <?= Html::submitButton('Изменить') ?>
<?php ActiveForm::end() ?>

<?php $deleteForm = ActiveForm::begin(['action' => Url::to(['/admin/test_delete'])]); ?>
    <?= $deleteForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Удалить') ?>
<?php ActiveForm::end() ?>

<?php $addQuestionForm = ActiveForm::begin(); ?>
    <?= $addQuestionForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Добавить вопрос') ?>
<?php ActiveForm::end() ?>

