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

<!--div class="cbp g-mb-50"
     data-controls="#filterControls"
     data-animation="quicksand"
     data-x-gap="30"
     data-y-gap="30"
     data-media-queries='[
               {"width": 1500, "cols": 3},
               {"width": 1100, "cols": 3},
               {"width": 800, "cols": 3},
               {"width": 480, "cols": 3},
               {"width": 300, "cols": 3}
             ]'>
    <!-- Cube Portfolio Blocks - Item -->
    <? /* echo \yii\widgets\ListView::widget([
        'dataProvider' => $widget->dataProvider,
        'itemView'     => 'collection-item',
        'emptyText'    => '',
        'options'      => [
            'class' => '',
            'tag'   => false,
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'cbp-item col-sm-4'
        ],
        'layout'       => '<div class="no-gutters row list-view">{items}</div><div class="row"><div class="col-md-12">{summary}</div><div class="col-md-12">{pager}</div></div>',
    ]) */ ?>
<!--/div-->
<div class="row">
    <? echo \yii\widgets\ListView::widget([
        'dataProvider' => $widget->dataProvider,
        'itemView'     => 'collection-block-item',
        'emptyText'    => '',
        'options'      => [
            'class' => '',
            'tag'   => false,
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'col-sm-6 col-lg-4 g-px-10 g-mb-10'
        ],
        'layout'       => '{items}<div class="row"><div class="col-md-12">{summary}</div><div class="col-md-12">{pager}</div></div>',
    ]) ?>
</div>