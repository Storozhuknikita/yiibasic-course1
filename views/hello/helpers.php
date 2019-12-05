<?php

use yii\helpers\Html;
$name = 'NameName';
?>

<?php

$isError = 1;

if($isError){
    $class = 'btn btn-warning';
}else{
    $class = 'btn btn-success';
}

$name = HTML::tag('span', Html::encode($name), ['class' => $class]);

echo $name;
?>

<?php /* Html::button('Подробнее', ['class' => 'teaser']) ?>
<?= Html::submitButton('Подтвердить', ['class' => 'submit']) ?>
<?= Html::resetButton('Отмена', ['class' => 'reset']) ?>

<?= Html::a('Календарь', ['calendar/view', 'userId' => 1], ['class' => 'calendar-link']) */?>
