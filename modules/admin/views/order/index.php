<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
            [
                'attribute' => 'status', //для измененний статуса заказов вместо 0/1
                'value' => function($data){
                    return $data->status ? '<span class="text-danger">Завершён</span>' : '<span class="text-success">Активен</span>';// если  $data->status = 1(true)
                },
                'format' => 'html', //для форматирования
            ],
            //'status',
            //'name',
            //'email:email',
            //'phone',
            //'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
