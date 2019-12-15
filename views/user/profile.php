<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'account'), 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Yii::t('app', 'account info') ?></h1>

    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'edit')), [
            'update', 'id' => $model->id
        ], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
        ],
    ]) ?>

</div>