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



<?php
foreach ($testArray as $test) {
    ?>
    <a href="<?= Url::to(['/testing/test_start', 'test_id' => $test->test_id]) ?>"><?= $test->name ?></a> <br/>
<?php

}
