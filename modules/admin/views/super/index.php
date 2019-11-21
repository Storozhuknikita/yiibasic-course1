<?php
/* @var $this yii\web\View */
use app\components\Comp;
use yii\web\Request;
?>
<h1>super/index</h1>
<?=Yii::$app->comp->show(Yii::$app->request->referrer)?>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
