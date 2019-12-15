<?php

/**
 * ДЗ по уроку 7
 * 1. Создайте личную страницу пользователя.

a. Пользователь может управлять своими личными данными.
b. Пользователь может управлять своими активностями.
2. Добавьте в функционал команды возможность отправки уведомлений только указанному пользователю (по email или ID).

3. Научите движок кэшировать пользовательские данные в личном кабинете.

4. Создайте страницу «Мой календарь» (https://github.com/Edofre/yii2-fullcalendar).

a. Страница содержит календарь на текущий месяц.
b. На странице можно переключиться на предыдущие или следующие месяцы.
c. В ячейках дней должны отображаться активности.
d. Если активность идёт более одного дня, она должна растягиваться между днями
 * .
5. Создайте страницу текущего дня (https://github.com/Edofre/yii2-fullcalendar). Страница должна содержать привязанные к дню события.

6. * Настройте отправку реальных писем.

7. * Настройте кэширование HTML-страниц целиком для страниц активностей.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
Yii::$app->cache->set('test', 42);
echo Yii::$app->cache->get('test');
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'started_at')->widget("kartik\date\DatePicker", [
        'name' => 'started_at',
        'options' => ['placeholder' => 'Выберите дату начала события'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'dd.MM.yyyy',
            'todayHighlight' => true
        ]
    ])->label($model->getAttributeLabel('started_at')) ?>

    <?= $form->field($model, 'finished_at')->widget("kartik\date\DatePicker", [
        'name' => 'finished_at',
        'options' => ['placeholder' => 'Выберите дату начала события'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'dd.MM.yyyy',
            'todayHighlight' => true
        ]
    ])->label($model->getAttributeLabel('finished_at')) ?>

    <?= $form->field($model, 'author_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\User::find()->orderBy(['username'=>SORT_ASC])->where(['status' => 10])->all(), 'id', 'username')) ?>

    <?= $form->field($model, 'main')->checkbox() ?>

    <?= $form->field($model, 'cycle')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
