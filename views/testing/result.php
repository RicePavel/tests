<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<p>Правильных ответов: <?= $countRight ?></p>
<p>Неправильных ответов: <?= $countNotRight ?></p>
<p>Процент правильных ответов: <?= $percentRight ?>%</p>
