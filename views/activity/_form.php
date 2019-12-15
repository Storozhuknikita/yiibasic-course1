<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
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
