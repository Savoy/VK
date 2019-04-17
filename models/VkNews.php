<?php
namespace app\models;

use Yii;
use yii\base\Model;

class VkNews extends Model
{
	public $id;

	public $owner;

	public $date;

	public $text;

	public $photos;

	public $likes;

	public function attributeLabels()
	{
		return [
			'owner' => 'Автор',
			'date' => 'Дата публикации',
			'text' => 'Текст новости',
			'photos' => 'Фотографии',
			'likes' => 'Кол-во лайков',
		];
	}

	public static function search($query)
	{
		if (($data = Yii::$app->cache->get(md5($query))) === false) {
			$vk = new \VK\Client\VKApiClient();

			$data = []; $count = 0; $next_from = null;
			do {
				$params = ['q' => $query, 'count' => 10];
				if ($next_from)
					$params['start_from'] = $next_from;
				$response = $vk->newsfeed()->search(Yii::$app->params['vk_access_token'], $params);

				foreach ($response['items'] as $item) {
					$photos = [];
					if (isset($item['attachments'])) {
						foreach ($item['attachments'] as $attachment) {
							if ($attachment['type'] == 'photo' && isset($attachment['photo'])) {
								$photos[] = array_pop($attachment['photo']['sizes'])['url'];
							}
						}
					}

					if ($item['owner_id'] > 0) {
						$user = $vk->users()->get(Yii::$app->params['vk_access_token'], ['user_ids' => $item['owner_id'], 'fields' => 'first_name,last_name']);
						$owner = $user[0]['first_name'].' '.$user[0]['last_name'];
					} else {
						$group = $vk->groups()->getById(Yii::$app->params['vk_access_token'], ['group_id' => ($item['owner_id']*-1), 'fields' => 'name']);
						$owner = $group[0]['name'];
					}

					$model = new self();
					$model->id = $item['id'];
					$model->owner = $owner;
					$model->date = $item['date'];
					$model->text = $item['text'];
					$model->likes = $item['likes']['count'];
					$model->photos = $photos;

					$data[$item['id']] = $model;
				}

				$count += count($response['items']);
				$next_from = $response['next_from'];
			} while ($count < 30/*$response['count']*/);

			if (count($data) > 0)
				Yii::$app->cache->add(md5($query), $data, 3600);
		}

		return array_values($data);
	}

	public static function find($query, $id)
	{
		if ($data = Yii::$app->cache->get(md5($query))) {
			if (isset($data[$id]))
				return  $data[$id];
		}

		return null;
	}
}
