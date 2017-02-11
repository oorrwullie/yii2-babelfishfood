<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\Languages */

$this->title = Yii::t('global', 'Update {modelClass}: ', [
    'modelClass' => 'Languages',
]) . $model->lang_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('global', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lang_id, 'url' => ['view', 'id' => $model->lang_id]];
$this->params['breadcrumbs'][] = Yii::t('global', 'Update');
?>
<div class="languages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
