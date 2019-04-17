<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $query string */

use yii\grid\GridView;

$this->title = 'Результаты поиска: '.$query;
$this->params['breadcrumbs'][] = ['url' => ['/news/index'], 'label' => 'Поиск новостей'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
	<div class="jumbotron">
		<p>Результаты поиска: <?= $query; ?></p>
	</div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
	            <?= GridView::widget([
		            'dataProvider' => $dataProvider,
		            'columns' => [
			            ['class' => 'yii\grid\SerialColumn'],
		            	'owner',
			            ['attribute' => 'date', 'format' => ['date', 'php:Y-m-d H:i:s']],
			            'likes',
			            ['attribute' => 'photos', 'value' => function ($data) { return count($data->photos); }],
			            ['class' => 'yii\grid\ActionColumn', 'buttons' => [
			            	'view' => function ($url, $model, $key) use ($query) {
					            $icon = \yii\helpers\Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
					            $options = [
						            'title' => Yii::t('yii', 'View'),
						            'aria-label' => Yii::t('yii', 'View'),
						            'data-pjax' => '0',
					            ];
					            return \yii\helpers\Html::a($icon, ['/news/view', 'query' => $query, 'id' => $model->id], $options);
				            }
			            ], 'template' => '{view}'],
		            ],
	            ]); ?>
            </div>
        </div>
    </div>
</div>
