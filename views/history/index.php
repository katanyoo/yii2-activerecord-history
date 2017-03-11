<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ActiveRecordLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-record-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'user_id',
            'ip',
            'description:ntext',
            'action',
            'model',
            'model_id',
            'field',
            'old_value:ntext',
            'new_value:ntext',
            'created_at:dateTime',
            // 'updatedAt',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>