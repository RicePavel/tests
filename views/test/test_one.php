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

<div class="test_description"><?= Html::encode($model->name) ?></div>

<div class="test_forms">
    <?php $changeForm = ActiveForm::begin([
        'method' => 'GET',
        'action' => Url::to(['/test/test_change', 'test_id' => $model->test_id]), 
        'options' => ['class' => 'test_change_form']
        ]); ?>
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>

    <?php $deleteForm = ActiveForm::begin(['action' => Url::to(['/test/test_delete']), 'options' => ['class' => 'delete_form']]); ?>
        <?= $deleteForm->field($model, 'test_id')->hiddenInput()->label(false) ?>
        <?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']) ?>
    <?php ActiveForm::end() ?>
</div>

<div class="clear"></div>
    
<?php $addQuestionForm = ActiveForm::begin(['method' => 'GET',
    'action' => Url::to(['/test/add_question', 'test_id' => $model->test_id]),
    'options' => ['class' => 'test_add_question_form']
    ]); ?>
    <?= Html::submitButton('Добавить вопрос', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>


<?php foreach ($model->sorted_questions as $question) { ?>

<div>
    <div><?= Html::encode($question->description) ?>
    
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/change_question']), 'method' => 'GET', 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button class="btn" >Изменить</button>
    <?php ActiveForm::end() ?>    
        
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/delete_question']), 'options' => ['style' => 'display: inline', 'class' => 'delete_form']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button class="btn" >Удалить</button>
    <?php ActiveForm::end() ?>
    
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/up_question']), 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button class="btn">Вверх</button>
    <?php ActiveForm::end() ?>
       
    <?php $form = ActiveForm::begin(['action' => Url::to(['test/down_question']), 'options' => ['style' => 'display: inline']]); ?>
        <input type="hidden" name="question_id" value="<?= $question->question_id ?>" />
        <input type="hidden" name="test_id" value="<?= $model->test_id ?>" />
        <button class="btn">Вниз</button>
    <?php ActiveForm::end() ?>
        
    </div>
    <ul>
    <?php foreach ($question->sorted_question_options as $option) { ?>
        <li><?= Html::encode($option->description) ?><?= ($option->is_correct ? ' (+)' : '') ?></li>
    <?php } ?>
    </ul>
</div>
    
<?php } ?>


