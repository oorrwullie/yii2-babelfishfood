<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\Languages */

$this->title = Yii::t('global', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('global', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
