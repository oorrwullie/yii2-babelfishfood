<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\Languages */

$this->title = Yii::t('global', 'Update {modelClass}: ', [
    'modelClass' => 'Language',
]) . $model->lang_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('global', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lang_name, 'url' => ['view', 'id' => $model->lang_id]];
$this->params['breadcrumbs'][] = Yii::t('global', 'Update');
?>
<div class="languages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
