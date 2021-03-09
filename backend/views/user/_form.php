<?php

use backend\models\UserForm;
use common\widgets\select2\Select2;
use common\widgets\toggle\ToggleInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var UserForm $model
 * @var \yii\widgets\ActiveForm $form
 */

?>
<div class="user-form">
    <?php $form = ActiveForm::begin([
        'id' => 'user_form',
        'enableAjaxValidation' => TRUE,
        'validationUrl' => ['validate', 'id' => $model->id]
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'status')->widget(ToggleInput::class, [
        'active_value' => 10,
        'checked' => $model->status
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'confirm_password')->passwordInput() ?>

    <?= $form->field($model, 'user_role_id')->widget(Select2::class,
        [
            'items' => $model->getListRoles(),
            'options' => [
                'prompt' => 'Select Role(s)',
                'multiple' => TRUE,
            ]
        ])
    ?>

    <div class="form-group text-right">
        <?= Html::a(Yii::t('common', 'Cancel'),
            ['user/index'],
            ['class' => 'btn btn-secondary mr-1']) ?>
        <?= Html::submitButton(Yii::t('common', 'Save'),
            ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
