<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

$sidebar = 'sidebarDashboards';
$route = 'site/index'
?>
<li class="nav-item">
    <?= Html::a("<i class='fe fe-home'></i> Dashboard",
        "#$sidebar",
        [
            'class' => "nav-link",
            'data-toggle' => "collapse",
            'role' => "button",
            'aria-expanded' => (($this->context->id == 'site') ? 'true' : 'false'),
            'aria-controls' => $sidebar
        ]) ?>
    <?= Html::beginTag('div', [
        'class' => 'collapse' . (($this->context->id == 'site') ? ' show' : NULL),
        'id' => $sidebar
    ]) ?>
    <ul class="nav nav-sm flex-column">
        <li class="nav-item">
            <?= Html::a('Home', [$route], [
                'class' => 'nav-link' . $this->activeRoute($route)]) ?>
        </li>
    </ul>
    <?= Html::endTag('div') ?>
</li>
