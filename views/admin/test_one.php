<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?= Html::encode($model->name) ?>

<?php $changeForm = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['/admin/change_test'])]); ?>
    <?= $changeForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Изменить') ?>
<?php ActiveForm::end() ?>

<?php $deleteForm = ActiveForm::begin(); ?>
    <?= $deleteForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Удалить') ?>
<?php ActiveForm::end() ?>

<?php $addQuestionForm = ActiveForm::begin(); ?>
    <?= $addQuestionForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Добавить вопрос') ?>
<?php ActiveForm::end() ?>

