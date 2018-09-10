<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;

function renderItem($item) {
    echo '<li>' . Html::a($item->title, $item->link)
        . ' ' .Html::a('Delete', ['delete', 'id' => $item->id], [
                'class' => 'btn btn-danger btn-xs',
            'data-confirm' => 'Are u sure?',
            'data-method' => 'post'
            ])
        . ' ' .Html::a('Add child', ['create', 'parent_id' => $item->id], ['class' => 'btn btn-default btn-xs']);
    if ($item->children) {
        echo '<ul>';
        foreach ($item->children as $child) {
            renderItem($child);
        }
        echo '</ul>';
    }
    echo '</li>';
}
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Add Menu Item'), ['create'], ['class' => 'btn btn-default']) ?>
    </p>
    <ul class="menu">
        <?php
    foreach ($dataProvider->models as $menuItem) {
        renderItem($menuItem);
    }
    ?>
    </ul>
    <?php Pjax::end(); ?>
</div>

<style>
    ul.menu li {
        margin-top: 5px;
    }
</style>
