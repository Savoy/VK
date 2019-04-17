<?php
namespace app\controllers;

use yii\web\Controller;
use yii\data\ArrayDataProvider;
use app\models\VkNews;

class NewsController extends Controller
{
	public function actionIndex()
	{
		$model = new VkNews();

		return $this->render('index', ['model' => $model]);
	}

	public function actionSearch($query)
	{
		$dataProvider = new ArrayDataProvider([
			'allModels' => VkNews::search($query),
			'sort' => [
				'attributes' => ['owner', 'date', 'likes'],
			],
			'pagination' => [
				'pageSize' => 5,
			],
		]);

		return $this->render('list', ['query' => $query, 'dataProvider' => $dataProvider]);
	}

	public function actionView($query, $id)
	{
		$model = VkNews::find($query, $id);

		return $this->render('view', ['query' => $query, 'model' => $model]);
	}
}
