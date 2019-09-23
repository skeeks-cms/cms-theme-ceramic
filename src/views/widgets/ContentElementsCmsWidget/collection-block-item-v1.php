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

$priceHelper = false;
if ($model->minPriceProduct) {
    $priceHelper = \Yii::$app->shop->cart->getProductPriceHelper($model->minPriceProduct);
}
?>
<div class="g-brd-gray-light-v4 g-color-gray-dark-v2 g-brd-around g-bg-white">
    <a class="d-block text-center" href="<?= $model->url; ?>">
        <? if ($model->image) : ?>
            <img class="img-fluid" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($model->image ? $model->image->src : null,
                new \skeeks\cms\components\imaging\filters\Thumbnail([
                    'w' => 345,
                    'h' => 230,
                    //'m' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                ]), $model->code
            ); ?>" title="<?= \yii\helpers\Html::encode($model->name); ?>" alt="<?= \yii\helpers\Html::encode($model->name); ?>" style="width: 100%;">
        <? else : ?>
            <img class="img-fluid g-transform-scale-1_1--parent-hover g-transition-0_5 g-transition--ease-in-out" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>" alt="<?= $model->name; ?>">
        <? endif; ?>
    </a>
    <div class="g-pt-15 g-px-15">
        <a class="h5 g-font-weight-600" href="<?= $model->url; ?>"><?= $model->name; ?></a>

        <div class="g-nowrap" style="overflow: hidden">
            <div class="pull-right"><?= $model->country; ?></div>
            <a class="pull-left" href="<?= $model->url; ?>"><?= $model->brand; ?></a>

        </div>
        <hr class="g-brd-gray-light-v4 g-my-10">
        <div class="text-center h6 g-mb-10">Товаров: <?= $model->getProducts()->count(); ?> шт.</div>
    </div>
</div>