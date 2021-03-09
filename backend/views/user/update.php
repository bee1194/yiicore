<?php

use backend\models\User;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $data_provider
 * @var User $model
 */
$this->title = 'Update User';
?>
<?= $this->render('//widgets/_header', [
    'link_btn' => NULL,
    'overview' => null,
]) ?>
<div class="container-fluid pb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?= $this->render('_form', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
