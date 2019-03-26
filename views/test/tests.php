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

<?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['class' => 'form-inline']]); ?>
    <?= $form->field($model, 'name')->textInput(['placeholder'=>'введите название теста...'])->label(false) ?>
    <?= Html::submitButton('Добавить тест', ['class' => 'add_test_button btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

<ul class="list-group">
<?php
foreach ($testArray as $test) {
    ?>
    <li class="list-group-item">
    <a href="<?= Url::to(['/test/test_one', 'test_id' => $test->test_id]) ?>"><?= Html::encode($test->name) ?></a> <br/>
    </li>
<?php
}
?>
</ul>