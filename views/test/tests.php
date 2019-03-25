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

<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
    <?= $form->field($model, 'name')->textarea()->label(false) ?>
    <?= Html::submitButton('Добавить тест') ?>
<?php ActiveForm::end(); ?>

<?php
foreach ($testArray as $test) {
    ?>
    <a href="<?= Url::to(['/test/test_one', 'test_id' => $test->test_id]) ?>"><?= $test->name ?></a> <br/>
<?php

}
