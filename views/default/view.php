<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\Languages */

$this->title = $model->lang_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('global', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('global', 'Update'), ['update', 'id' => $model->lang_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('global', 'Delete'), ['delete', 'id' => $model->lang_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('global', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
  //          'lang_id',
            'lang_name',
            'native_name',
            'lang_code',
            'active:boolean',
        ],
    ]) ?>

</div>
