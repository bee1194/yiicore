<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

?>
<div class="navbar-user d-md-none">
    <div class="dropdown">
        <?= Html::beginTag('a', [
            'href' => '#',
            'id' => 'sidebarIcon',
            'class' => 'dropdown-toggle',
            'role' => 'button',
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false'
        ]) ?>
        <div class="avatar avatar-sm avatar-online">
            <?= Html::img('/img/hia-sq.png', [
                'class' => 'avatar-img rounded-circle',
                'alt' => '...'
            ]) ?>
        </div>
        <?= Html::endTag('a') ?>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
            <?= Html::a('Logout', ['site/logout'], [
                'class' => 'dropdown-item',
                'data-method' => 'post'
            ]) ?>
        </div>
    </div>
</div>
