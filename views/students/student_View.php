<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Students */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
           // 'userid',
            'full_name',
            'father_name',
            'mother_name',
            'address:ntext',
            'contact_number',
            'class',
            'age',
            'iq_score',
            'social_status',
        ],
    ]) ?>

</div>
