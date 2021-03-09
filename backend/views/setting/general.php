<?php
/**
 * @var View $this
 * @var General $model
 */

use common\models\settings\General;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = Yii::t('common', 'Setting');
?>
<?= $this->render('//widgets/_header',
    ['link_btn' => null, 'overview' => null]) ?>
<div class="container-fluid pb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <div class="form-group text-right">
                        <?= Html::submitButton('Save',
                            ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
