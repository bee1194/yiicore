<?php

use common\models\Permission;
use common\models\Role;
use common\widgets\Alert;
use common\widgets\checkbox\CheckBoxInput;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var Role[] $roles
 * @var Permission[] $permissions
 */

$this->title = 'Permission';
$this->params['breadcrumbs'][] = ['label' => 'Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Html::beginForm() ?>
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h1 class="header-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-auto">
                    <?= Html::button('Save',
                        ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
                </div>
            </div>
        </div>
        <?= Alert::widget([
            'options' => [
                'class' => 'mt-4 mb-4'
            ]
        ]) ?>
    </div>
</div>
<div class="container-fluid pb-4">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="border-top-0" scope="col" colspan="2"></th>
                        <?php foreach ($roles as $role): ?>
                            <th scope="col" class="border-top-0 text-center">
                                <?= Html::encode($role->name) ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($permissions as $parent): $flag = 0; ?>

                        <?php foreach ($children = $parent->children as $permission): ?>
                            <tr>
                                <?php if ($flag == 0): ?>
                                    <td class="align-middle font-weight-bold" rowspan="<?= count($children) ?>">
                                        <?= $parent->description ?>
                                    </td>
                                    <?php $flag = 1;
                                endif; ?>

                                <td>
                                    <?= Html::encode($permission->description) ?>
                                </td>

                                <?php foreach ($roles as $role): ?>

                                    <?php if ($role->isAdmin()): ?>
                                        <td class="text-center">
                                            <?= CheckBoxInput::widget([
                                                'id' => "access_{$role->id}_{$permission->id}",
                                                'checked' => true,
                                                'disabled' => true
                                            ]) ?>
                                        </td>
                                    <?php else: ?>
                                        <td class="text-center">
                                            <?= CheckBoxInput::widget([
                                                'id' => "access_{$role->id}_{$permission->id}",
                                                'checked' => $role->hasPermission($permission->name),
                                                'name' => "access[$role->id][$permission->id]",
                                            ]) ?>
                                        </td>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= Html::endForm() ?>

