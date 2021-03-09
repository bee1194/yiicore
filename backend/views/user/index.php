<?php

use backend\models\User;
use common\helper\StatusBehavior;
use common\widgets\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $data_provider
 */
$this->title = 'User';
?>
<?= $this->render('//widgets/_header', [
    'link_btn' => Yii::$app->user->can('user upsert') ?
        Html::a('Create',
            ['user/create'],
            [
                'class' => 'btn btn-primary'
            ]) : NULL,
    'overview' => null,
]) ?>
<div class="container-fluid pb-4">
    <form>
        <div class="row mb-3">
            <div class="input-group col-md-3 mb-3">
                <?= Html::textInput('username', $filter['username'] ?? NULL,
                    ['class' => 'form-control form-control-prepended height-input', 'placeholder' => 'Username']) ?>
            </div>
            <div class="input-group col-md-3 mb-3">
                <?= Select2::widget([
                    'options' => [
                        'prompt' => 'Status',
                    ],
                    'value' => $filter['state'] ?? NULL,
                    'name' => 'state',
                    'items' => StatusBehavior::STATES,

                ]) ?>
            </div>
            <div class="input-group col-md-3 mb-3">
                <?= Select2::widget([
                    'options' => [
                        'prompt' => 'Role',
                    ],
                    'value' => $filter['user_role'] ?? NULL,
                    'name' => 'user_role',
                    'items' => User::getRoleName(),
                ]) ?>

            </div>
            <div class="col-md-3 mb-3">
                <a href="<?= Url::to(['index']) ?>" class="btn btn-white btn-main mr-1">
                    <span class="fe fe-refresh-cw"></span>
                </a>

                <button class="btn btn-white btn-main button-search" href="#" type="submit">
                    <i class="fe fe-search"></i>
                </button>

            </div>
        </div>
    </form>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $data_provider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'email',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => 'viewStatus'
                ],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'role_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($roles = $model->roles) {
                            $roles = ArrayHelper::getColumn($roles, 'name');

                            return implode('<br>', $roles);
                        }

                        return NULL;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'buttons' => [
                        'update' => Yii::$app->user->can('user upsert') ? function ($url, $model) {
                            return Html::a("<i class='fe fe-edit'></i>", $url);
                        } : NULL,
                        'delete' => Yii::$app->user->can('user delete') ? function ($url, $model) {
                            return Html::a("<i class='fe fe-trash'></i>", $url,
                                [
                                    'data-confirm' => 'Do you want to delete this item?',
                                    'data-method' => 'post',
                                ]);
                        } : NULL,
                    ],
                ],
            ]
        ]) ?>
    </div>
</div>
