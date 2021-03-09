<?php

use common\helper\StatusBehavior;
use common\widgets\select2\Select2;
use common\widgets\toggle\ToggleInput;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Role';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('//widgets/_header', [
    'link_btn' => Yii::$app->user->can('role upsert') ?
        Html::a('Create',
            ['create'],
            [
                'class' => 'btn btn-primary'
            ]) : NULL,
    'overview' => null,
]) ?>
<div class="container-fluid pb-4">
    <form>
        <div class="row mb-3">
            <div class="input-group col-md-3 mb-3">
                <?= Html::textInput('name', $filter['name'] ?? NULL,
                    ['class' => 'form-control form-control-prepended height-input', 'placeholder' => 'Name']) ?>
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
            <div class="col-md-3 mb-3">
                <a href="<?= Url::to(['index']) ?>" class="btn btn-white btn-main mr-1">
                    <span class="fe fe-refresh-cw"></span>
                </a>
                <button class="btn btn-main btn-white" type="submit">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return ToggleInput::widget([
                            'checked' => $model->status,
                            'action' =>
                                [
                                    'url' => Url::to(['role/status']),
                                    'request_type' => 'post',
                                    'sender' => $model->id,
                                ]
                        ]);
                    }
                ],
                [
                    'attribute' => 'created_by',
                    'value' => 'author.username'
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => 'updater.username'
                ],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'buttons' => [
                        'update' => Yii::$app->user->can('role upsert') ? function (
                            $url,
                            $model) {
                            return Html::a("<i class='fe fe-edit'></i>", $url);
                        } : NULL,
                        'delete' => Yii::$app->user->can('role delete') ? function (
                            $url,
                            $model) {
                            return Html::a("<i class='fe fe-trash'></i>", $url,
                                [
                                    'data-confirm' => 'Do you want to delete this item?',
                                    'data-method' => 'post',
                                ]);
                        } : NULL,
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
