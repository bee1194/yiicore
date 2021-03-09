<?php
/**
 * @var View $this
 */

use yii\helpers\Html;
use yii\web\View;

$sidebar = 'sidebarRoles';
$route = 'role/index';
?>
<li class="nav-item">
    <?= Html::a("<i class='fe fe-shield'></i> Role",
        "#$sidebar",
        [
            'class' => "nav-link",
            'data-toggle' => "collapse",
            'role' => "button",
            'aria-expanded' => (($this->context->id == 'role') ? 'true' : 'false'),
            'aria-controls' => $sidebar
        ]) ?>
    <?= Html::beginTag('div', [
        'class' => 'collapse' . (($this->context->id == 'role') ? ' show' : NULL),
        'id' => $sidebar
    ]) ?>
    <ul class="nav nav-sm flex-column">
        <li class="nav-item">
            <?= Html::a('Role', [$route], [
                'class' => 'nav-link' . $this->activeRoute(['role/index', 'role/create', 'role/update'])]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Permission', ['role/permission'], [
                'class' => 'nav-link' . $this->activeRoute('role/permission')]) ?>
        </li>
    </ul>
    <?= Html::endTag('div') ?>
</li>
