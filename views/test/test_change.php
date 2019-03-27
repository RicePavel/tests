<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
    <?= $form->field($model, 'name')->textarea()->label(false) ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

