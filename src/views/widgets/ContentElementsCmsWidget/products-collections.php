<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */

?>
<? if ($widget->label) : ?>
    <h1 class="size-17 margin-bottom-20"><?= $widget->label; ?></h1>
<? endif; ?>


    <? echo \yii\widgets\ListView::widget([
        'dataProvider' => $widget->dataProvider,
        'itemView'     => 'collection-block-item-'.  \Yii::$app->ceramic->collection,
        'emptyText'    => '',
        'options'      => [
            'class' => '',
            'tag'   => false,
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'col-sm-6 col-lg-4 g-px-5 g-mb-10 item'
        ],
        'pager'        => [
            'class' => \skeeks\cms\themes\unify\widgets\ScrollAndSpPager::class
        ],
        'layout'       => '<div class="row"><div class="col-md-12">{summary}</div></div>
<div class="no-gutters row list-view">{items}</div>
<div class="row"><div class="col-md-12">{pager}</div></div>',
    ]) ?>
