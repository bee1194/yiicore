<?php

use common\widgets\toggle\ToggleInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\Role
 * @var $form \yii\widgets\ActiveForm
 */
?>

<div class="role-form">
    <?php $form = ActiveForm::begin(['id' => 'roleForm']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => TRUE]) ?>

    <?= $form->field($model, 'status', ['enableClientValidation' => FALSE])
        ->widget(ToggleInput::class, [
            'active_value' => 10,
            'checked' => $model->status,
            'disabled' => $model->is_primary ? TRUE : FALSE,
        ]) ?>

    <div class="form-group text-right">
        <?= Html::a(Yii::t('common', 'Cancel'),
            ['role/index'],
            ['class' => 'btn btn-secondary mr-1']) ?>
        <?= Html::submitButton(Yii::t('common', 'Save'),
            ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
