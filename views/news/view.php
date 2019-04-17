<?php

/* @var $this yii\web\View */
/* @var $model app\models\VkNews */
/* @var $query string */

use yii\widgets\DetailView;

$this->title = 'Просмотр новости';
$this->params['breadcrumbs'][] = ['url' => ['/news/index'], 'label' => 'Поиск новостей'];
$this->params['breadcrumbs'][] = ['url' => ['/news/search', 'query' => $query], 'label' => 'Результаты поиска: '.$query];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
	            <?= DetailView::widget([
		            'model' => $model,
		            'attributes' => [
		            	'date:datetime',
			            'owner',
			            'text:ntext',
			            ['attribute' => 'photos', 'value' => function ($model) {
				            if (!empty($model->photos)) {
				            	$photos = [];
					            foreach ($model->photos as $photo) {
				            		$photos[] = [
				            			'src' => $photo,
							            'preview_src' => $photo,
						            ];
					            }
					            return \skeeks\yii2\nanogalleryWidget\NanogalleryWidget::widget([
						            'items' => $photos,
						            'clientOptions' => ['thumbnailHeight' => 300],
					            ]);
				            } else return null;
			            }, 'format' => 'raw'],
			            'likes',
		            ],
	            ]); ?>
            </div>
        </div>
    </div>
</div>
