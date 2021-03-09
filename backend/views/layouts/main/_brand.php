<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

?>
<?= Html::beginTag('button', [
    'class' => 'navbar-toggler',
    'type' => 'button',
    'data-toggle' => 'collapse',
    'data-target' => '#sidebarCollapse',
    'aria-controls' => 'sidebarCollapse',
    'aria-expanded' => 'false',
    'aria-label' => 'Toggle navigation'
]) ?>
<span class='navbar-toggler-icon'></span>
<?= Html::endTag('button') ?>

<?= Html::a(
    Html::img('/img/hia-sq.png', [
        'class' => 'navbar-brand-img mx-auto',
        'alt' => '...'
    ]),
    Yii::$app->homeUrl,
    [
        'class' => 'navbar-brand'
    ]) ?>
