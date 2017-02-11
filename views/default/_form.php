<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model oorrwullie\babelfishfood\models\Languages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_name')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>

    <?= $form->field($model, 'native_name')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>

    <?= $form->field($model, 'lang_code')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>

    <?= $form->field($model, 'active')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('global', 'Create') : Yii::t('global', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
