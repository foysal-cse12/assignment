<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Students */

$this->title = 'Update Students: ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
//_form_update
?>
<div class="students-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
