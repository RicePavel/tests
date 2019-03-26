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


<ul class="list-group">
    <?php
    foreach ($testArray as $test) {
        ?>
    <li class="list-group-item"><a href="<?= Url::to(['/testing/test_start', 'test_id' => $test->test_id]) ?>"><?= Html::encode($test->name) ?></a></li>
    <?php
    }
    ?>
</ul>