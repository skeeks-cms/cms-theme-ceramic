<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 *
 * @var \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement $model
 *
 */
/* @var $this yii\web\View */

?>

<div class="u-block-hover g-parent">
    <a href="<?= $model->url; ?>">
    <? if ($model->image) : ?>
    <img class="img-fluid g-transform-scale-1_1--parent-hover g-transition-0_5 g-transition--ease-in-out" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($model->image ? $model->image->src : null,
        new \skeeks\cms\components\imaging\filters\Thumbnail([
            'w' => 500,
            'h' => 335,
            //'m' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
        ]), $model->code
    ); ?>" title="<?= \yii\helpers\Html::encode($model->name); ?>" alt="<?= \yii\helpers\Html::encode($model->name); ?>" />
    <? else : ?>
        <img class="img-fluid g-transform-scale-1_1--parent-hover g-transition-0_5 g-transition--ease-in-out" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>" alt="<?= $model->name; ?>">
    <? endif; ?>

    <div class="d-flex w-100 h-100 g-bg-primary-opacity-0_6 opacity-0 g-opacity-1--parent-hover g-pos-abs g-top-0 g-left-0 g-transition-0_3 g-transition--ease-in u-block-hover__additional--fade u-block-hover__additional--fade-in g-pa-20">

    </div>
    </a>
</div>
<div class="text-center g-pa-25 mb-1">
    <div class="card-title">
        <a href="<?= $model->url; ?>" title="><?= $model->name; ?>" data-pjax="0" class="g-color-gray-dark-v2 g-font-weight-600 g-line-height-1"><?= $model->name; ?></a>

    </div>
    <p class="mb-0"><? if ($model->relatedPropertiesModel->getAttribute('brand')) : ?><?=$model->relatedPropertiesModel->getAttribute('brand');?><? ?>, <? endif; ?> <? if ($model->relatedPropertiesModel->getAttribute('	Country_of_manufacture')) : ?><?=$model->relatedPropertiesModel->getAttribute('	Country_of_manufacture');?><? ?><? endif; ?> </p>
</div>

