<?php
/**

1) Создайте вёрстку страницы задачи на день.
Пользователь должен будет попадать на неё при создании или редактировании события, выбранного в календаре.
- На странице должна отображаться информация о событии.
- Со страницы нужно иметь возможность удобно вернуться к календарю.
- Со страницы нужно иметь возможность перейти к редактированию события.

2) Создайте форму добавления нового события в календарь пользователя.
- Форма должна валидироваться в соответствии с полями.
- Пока данные формы можно не сохранять, а просто выводить для дебага на отдельной странице submit.

3) * Разрешите пользователю прикреплять несколько файлов к событию.
- Несколько файлов нужно прикреплять за одну загрузку.

*/

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