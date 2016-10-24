<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Students', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('My Profile', ['/users/user_profile'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Student Account Update', ['/users/student_account'], ['class' => 'btn btn-success']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'userid',
            'full_name',
            'father_name',
            //'mother_name',
            // 'address:ntext',
             'class',
             'iq_score',
             'contact_number',      
            // 'age',
            // 'social_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
