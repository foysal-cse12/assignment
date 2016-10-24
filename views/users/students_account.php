<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Accounts';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['/students/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'password',
            'email:email',
            //'user_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
