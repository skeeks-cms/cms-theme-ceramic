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


$this->registerCss(<<<CSS
.g-bg-hover {
    position: absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color: rgba(0,0,0, 0.0);
    z-index: 0;
} 

.u-block-hover:hover .g-bg-hover {
    position: absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color: rgba(0,0,0, 0.5);
    transition: background 0.5s ease;
} 
CSS
);
$priceHelper = false;
if ($model->minPriceProduct) {
    $priceHelper = \Yii::$app->shop->cart->getProductPriceHelper($model->minPriceProduct);
}
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
    <div class="g-bg-hover">

    </div>
    <div class="u-block-hover__additional--partially-slide-up text-center g-z-index-1 mt-auto">
        <div class="u-block-hover__visible g-pa-25">
            <span class="d-block g-color-white-opacity-0_7 g-font-weight-600 g-font-size-12 mb-2">Коллекция</span>
            <h2 class="h4 g-color-white g-font-weight-600 mb-3">
                <a class="u-link-v5 g-brd-bottom g-brd-2 g-brd-white--hover g-color-white g-cursor-pointer g-pb-2" href="<?= $model->url; ?>"><?= $model->name; ?></a>
            </h2>
            <h4 class="d-inline-block g-color-white-opacity-0_7 g-font-size-11 mb-0">
                <?= $model->brand; ?>
                <?= $model->country; ?>
            </h4>
            <? if ($priceHelper) : ?>
            <span class="g-color-white-opacity-0_7 g-pos-rel g-top-2 mx-2">&#183;</span>
            <span class="g-color-white-opacity-0_7 g-font-size-10 text-uppercase">от <?= $priceHelper->basePrice->money;  ?></span>
            <? endif; ?>

        </div>

        <a class="d-inline-block g-brd-bottom g-brd-white g-color-white g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover g-mb-30" href="<?= $model->url; ?>">Подробнее</a>
    </div>
</article>