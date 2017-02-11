<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\LanguagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'lang_name') ?>

    <?= $form->field($model, 'native_name') ?>

    <?= $form->field($model, 'lang_code') ?>

    <?= $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('global', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('global', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
