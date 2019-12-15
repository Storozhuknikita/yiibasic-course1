<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo Html::tag('h1', 'Добавить задачу');

$form = ActiveForm::begin([
    'enableClientValidation' => true,
    'method' => 'POST',
    'action' => \yii\helpers\Url::to(['tasks/index'])
]);

echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'description')->textInput();
echo $form->field($model, 'deadline')->textInput();

echo Html::submitButton('Отправить', ['class' => 'btn btn-warning']);
ActiveForm::end();