<?php
/* @var $this yii\web\View */
?>
<h1>You are Administrator</h1>

<p>
    You can to view all users
    <?= \yii\helpers\Html::a('User', ['/user/index'], ['class' => 'btn btn-primary']) ?>
    and all activities
    <?= \yii\helpers\Html::a('Activities', ['/activity'], ['class' => 'btn btn-primary']) ?>
</p>