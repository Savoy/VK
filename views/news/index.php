<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Поиск новостей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
            	'id' => 'news-search-form',
	            'action' => \yii\helpers\Url::to(['/news/search']),
	            'method' => 'get',
            ]); ?>

                <?= $form->field($model, 'text')->textInput(['autofocus' => true, 'name' => 'query']) ?>


                <div class="form-group">
                    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
