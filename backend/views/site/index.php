<?php

/**
 * @var $this yii\web\View
 */

$this->title = Yii::t('common', 'Home');
$this->params['breadcrumbs'][] = Yii::$app->name;
?>
<?= $this->render('//widgets/_header',
    ['link_btn' => null, 'overview' => null]) ?>
