<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'enableClientValidation' => true,
    'method' => 'POST',
    'action' => \yii\helpers\Url::to(['hello/forms'])
]);

echo $form->field($model, 'username')->textInput();
echo $form->field($model, 'email')->textInput();
echo $form->field($model, 'phone')->textInput();
echo $form->field($model, 'sendEmail')->checkbox();

echo Html::submitButton('Отправить', ['class' => 'btn btn-warning']);
ActiveForm::end();