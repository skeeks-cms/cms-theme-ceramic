<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 *
 * @var skeeks\cms\themes\ceramic\models\CollectionCmsContentElement $model
 *
 */
/* @var $this yii\web\View */
if ($model->minPriceProduct) {
    echo $model->minPriceProduct->shopProduct->baseProductPriceValue;
} else {
    echo "НЕТ";
}

echo count($model->products);

?>
<!-- Blog Background Overlay Blocks -->
<article class="u-block-hover">
    <div class="g-bg-cover g-bg-bluegray-gradient-opacity-v1--after">
        <? if ($model->image) : ?>
            <img class="d-flex align-items-end u-block-hover__main--mover-down" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($model->image ? $model->image->src : null,
                new \skeeks\cms\components\imaging\filters\Thumbnail([
                    'w' => 500,
                    'h' => 600,
                    //'m' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                ]), $model->code
            ); ?>" alt="<?= $model->name; ?>">
        <? else : ?>
            <img class="d-flex align-items-end u-block-hover__main--mover-down" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>" alt="<?= $model->name; ?>">
        <? endif; ?>
    </div>
    <div class="u-block-hover__additional--partially-slide-up text-center g-z-index-1 mt-auto">
        <div class="u-block-hover__visible g-pa-25">
            <span class="d-block g-color-white-opacity-0_7 g-font-weight-600 g-font-size-12 mb-2">Коллекция</span>
            <h2 class="h4 g-color-white g-font-weight-600 mb-3">
                <a class="u-link-v5 g-brd-bottom g-brd-2 g-brd-white--hover g-color-white g-cursor-pointer g-pb-2" href="<?= $model->url; ?>"><?= $model->name; ?></a>
            </h2>
            <h4 class="d-inline-block g-color-white-opacity-0_7 g-font-size-11 mb-0">
                производитель
                <a class="g-color-white-opacity-0_7 text-uppercase" href="<?= $model->url; ?>"><?= $model->country; ?></a>
            </h4>
            <span class="g-color-white-opacity-0_7 g-pos-rel g-top-2 mx-2">&#183;</span>
            <span class="g-color-white-opacity-0_7 g-font-size-10 text-uppercase">цена от
            </span>
        </div>

        <a class="d-inline-block g-brd-bottom g-brd-white g-color-white g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover g-mb-30" href="<?= $model->url; ?>">Подробнее</a>
    </div>
</article>

<div class="u-block-hover g-parent">
    <a href="">
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

