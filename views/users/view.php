<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['/students/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update_student_account', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Change Password', ['change_student_password','id'=>$model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
           // 'password',
            'email:email',
            //'user_type',
        ],
    ]) ?>

</div>
