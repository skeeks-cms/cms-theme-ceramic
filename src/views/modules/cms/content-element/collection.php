<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
/* @var $this yii\web\View */
skeeks\assets\unify\base\UnifyHsCubeportfolioAsset::register($this);
skeeks\assets\unify\base\UnifyHsRatingAsset::register($this);

$this->registerJs(<<<JS
$.HSCore.components.HSRating.init($('.js-rating-show'), {
  spacing: 2
});
$.HSCore.components.HSCubeportfolio.init('.cbp');
JS
);

$this->registerCss(<<<CSS
.g-parent {
    text-align: center;
}
.cbp img {
    width: auto;
    min-height: 200px;
    max-width: 100%;
    display: inline;
}
.card-prod {
    padding-bottom: 40px;
}
.card-prod .card-prod--title {
    min-height: 60px;
}
.cbp-filter-item-active .u-btn-outline-darkgray {
    color: #fff;
    background-color: #333;
}
CSS
);

$collection = new \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement($model->toArray());

$reviews2Count = $model->relatedPropertiesModel->getSmartAttribute('reviews2Count');
$rating = $model->relatedPropertiesModel->getSmartAttribute('reviews2Rating');

?>
<section class="sx-product-card-wrapper g-mt-0 g-pt-0 g-pb-0 to-cart-fly-wrapper">
    <? if ($model->image) : ?>
        <link itemprop="image" href="<?= $model->image->absoluteSrc; ?>">
    <? endif; ?>
    <div class="container g-py-20">

        <div class="row">
            <div class="col-md-12">
                <?= $this->render('@app/views/breadcrumbs', [
                    'model' => $model,
                    //'title' => "Коллекция &laqou;".."&raquo;"
                    /*'isShowLast' => true,*/
                    'isShowH1'   => false,
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="sx-product-images g-ml-40 g-mr-40">
                    <?
                    $images = [];
                    if ($model->image) {
                        $images[] = $model->image;
                    }
                    if ($model->images) {
                        $images = \yii\helpers\ArrayHelper::merge($images, $model->images);
                    }
                    ?>
                    <? if ($images) : ?>

                        <div id="carouselCus1" class="js-carousel g-pt-10 g-mb-10 sx-stick-slider"
                             data-infinite="true"
                             data-fade="true"
                             data-arrows-classes="u-arrow-v1 g-brd-around g-brd-gray-dark-v5 g-absolute-centered--y g-width-45 g-height-45 g-font-size-25 g-color-gray-dark-v5 g-color-primary--hover rounded-circle"
                             data-arrow-left-classes="fa fa-angle-left g-left-minus-20"
                             data-arrow-right-classes="fa fa-angle-right g-right-minus-20"
                             data-nav-for="#carouselCus2">

                            <? foreach ($images as $image) : ?>
                                <div class="js-slide g-bg-cover">
                                    <!--w-100-->
                                    <img class="img-fluid" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($image->src,
                                        new \skeeks\cms\components\imaging\filters\Thumbnail([
                                            'w' => 700,
                                            'h' => 500,
                                            'm' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                                        ]), $model->code
                                    ); ?>" alt="<?= $model->name; ?>">
                                </div>
                            <? endforeach; ?>

                        </div>

                        <? if (count($images) > 1) : ?>
                            <div id="carouselCus2" class="js-carousel text-center u-carousel-v3 g-mx-minus-5 sx-stick-navigation"
                                 data-infinite="true"
                                 data-center-mode="true"
                                 data-slides-show="8"
                                 data-is-thumbs="true"
                                 data-focus-on-select="false"
                                 data-nav-for="#carouselCus1"
                                 data-arrows-classes="u-arrow-v1 g-absolute-centered--y g-width-45 g-height-45 g-font-size-30 g-color-gray-dark-v5 g-color-primary--hover rounded-circle"
                                 data-arrow-left-classes="fa fa-angle-left g-left-minus-40"
                                 data-arrow-right-classes="fa fa-angle-right g-right-minus-40"
                            >

                                <? foreach ($images as $image) : ?>
                                    <div class="js-slide g-cursor-pointer g-px-5">
                                        <img class="img-fluid" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($image->src,
                                            new \skeeks\cms\components\imaging\filters\Thumbnail([
                                                'w' => 75,
                                                'h' => 75,
                                                'm' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                                            ]), $model->code
                                        ); ?>" alt="<?= $model->name; ?>">
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>


                    <? else: ?>
                        <img class="w-100 u-block-hover__main--zoom-v1" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>" alt="<?= $collection->name; ?>">
                    <? endif; ?>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="product-info ss-product-info">

                    <div class="product-info-header">

                        <div class="topmost-row">
                            <div class="row no-gutters">
                                <div class="col-5">
                                    <div data-product-id="<?= $model->id; ?>" class="item-lot">Код:&nbsp;<?= $model->id; ?></div>
                                </div>

                                <div class="col-7">
                                    <div class="feedback-review cf float-right">
                                        <div class="product-rating float-right">
                                            <div class="js-rating-show g-color-yellow" data-rating="<?=$rating; ?>"></div>
                                        </div>
                                        <div class="sx-feedback-links float-right g-mr-10">
                                            <a href="#sx-reviews" class="sx-scroll-to g-color-gray-dark-v2 g-font-size-13 sx-dashed  g-brd-primary--hover g-color-primary--hover">
                                                <?
                                                echo \Yii::t(
                                                    'app',
                                                    '{n, plural, =0{нет отзывов} =1{один отзыв} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзыва}}',
                                                    ['n' => $reviews2Count]
                                                );
                                                ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>





                        <h1 class="g-color-gray-dark-v2" itemprop="name">
                            <?= $model->name; ?>
                        </h1>
                        <? if ($collection->brand) : ?>
                            <div class="row g-pb-10 g-pt-10">
                                <div class="col-sm-6">Производитель:</div><div class="col-sm-6"><strong><?= $collection->brand; ?></strong></div>
                            </div>
                        <? endif; ?>
                        <? if ($collection->country) : ?>
                            <div class="row g-pb-20">
                                <div class="col-sm-6">Страна:</div><div class="col-sm-6"><strong><?= $collection->country; ?></strong></div>
                            </div>
                        <? endif; ?>


                        <? if ($collection->products) : ?>
                            <a href="#" onclick="new sx.classes.Location().href('#portfolio-section')" class="btn btn-xxl u-btn-primary g-rounded-50 g-font-size-18">Смотреть товары коллекции</a>
                        <? endif; ?>

                        <div class="product-price g-mt-10 g-mb-10">

                            <span class="current ss-price h1 g-font-weight-600 g-color-primary"><?/*= $model->basePrice->money;*/ ?></span>
                        </div>

                        <? if ($model->description_short) : ?>
                            <div class="sx-description-short g-color-gray-dark-v4">
                                <?= $model->description_short; ?>
                                <p>
                                    <a href="#sx-description" class="sx-scroll-to g-color-gray-dark-v2 g-font-size-13 sx-dashed g-brd-primary--hover g-color-primary--hover">
                                        Подробнее
                                    </a>
                                </p>
                            </div>
                        <? endif; ?>


                        <div class="sx-product-delivery-info g-mt-20">
                            <!--<ul class="nav d-flex justify-content-between g-font-size-12 text-uppercase" role="tablist" data-target="nav-1-1-default-hor-left">
                                <li class="nav-item">
                                    <a class="nav-link g-color-primary--parent-active g-pa-0 g-pb-1 active show" data-toggle="tab" href="#nav-1-1-default-hor-left--3" role="tab" aria-selected="true">
                                        <span class="u-icon-v3 g-rounded-50x">
                                            <i class="icon-christmas-005 u-line-icon-pro"></i>
                                        </span>
                                        <span>Условия доставки</span>
                                    </a>
                                </li>
                                <li class="nav-item g-brd-bottom g-brd-gray-dark-v4">
                                    <a class="nav-link g-color-primary--parent-active g-pa-0 g-pb-1 show" data-toggle="tab" href="#nav-1-1-default-hor-left--1" role="tab" aria-selected="false">View Size Guide</a>
                                </li>
                            </ul>-->

                            <!-- Nav tabs -->
                            <!--u-nav-v1-1-->
                            <ul class="nav nav-justified  u-nav-v5-1" role="tablist" data-target="nav-1-1-accordion-default-hor-left-icons" data-tabs-mobile-type="accordion" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#nav-1-1-accordion-default-hor-left-icons--1" role="tab">
                                        <!--<i class="icon-christmas-037 u-tab-line-icon-pro "></i>-->
                                        <i class="fas fa-truck g-mr-3"></i>
                                        Условия доставки и оплаты
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#nav-1-1-accordion-default-hor-left-icons--2" role="tab">
                                        <!--<i class="icon-communication-025 u-tab-line-icon-pro g-mr-3"></i>-->
                                        <i class="far fa-question-circle g-mr-3"></i>
                                        Помощь
                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div id="nav-1-1-accordion-default-hor-left-icons" class="tab-content">
                                <div class="tab-pane fade show active" id="nav-1-1-accordion-default-hor-left-icons--1" role="tabpanel">
                                    <? $shopDeliveries = \skeeks\cms\shop\models\ShopDelivery::find()->active()->all(); ?>
                                    <? if ($shopDeliveries) : ?>
                                        <p><strong>Варианты доставки</strong></p>
                                        <ul>
                                            <? foreach ($shopDeliveries as $delivery) : ?>
                                                <li><?= $delivery->name; ?></li>
                                            <? endforeach;?>
                                        </ul>
                                    <? endif; ?>
                                    <? $shopPaySystems = \skeeks\cms\shop\models\ShopPaySystem::find()->active()->all(); ?>
                                    <? if ($shopPaySystems) : ?>
                                        <p><strong>Варианты оплаты</strong></p>
                                        <ul>
                                            <? foreach ($shopPaySystems as $paySystem) : ?>
                                                <li><?= $paySystem->name; ?></li>
                                            <? endforeach;?>
                                        </ul>
                                    <? endif; ?>
                                </div>

                                <div class="tab-pane fade" id="nav-1-1-accordion-default-hor-left-icons--2" role="tabpanel">
                                    <p class="g-font-weight-600">Проблема с добавлением товара в корзину?</p>
                                    <p>Если у вас появилась сложность с добавлением товара в корзину, вы можете позвонить по номеру
                                        <a href="tel:<?= $this->theme->phone; ?>"><?= $this->theme->phone; ?></a> и оформить заказ по телефону.</p>
                                    <p>Пожалуйста, сообщите, какие проблемы с добавлением товара в корзину вы испытываете:</p>
                                </div>
                            </div>

                            <!-- End Nav tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <? if ($model->description_full) : ?>
        <div class="container">
            <div class="col-md-12 sx-content" id="sx-description">
                <h2>Описание</h2>
                <?= $model->description_full; ?>

            </div>
        </div>
    <? endif; ?>
</section>

<!-- Cube Portfolio Blocks - Content -->
<section id="portfolio-section" class="container g-pt-10 g-pb-10 g-brd-gray-light-v4">
    <div class="container">
        <!-- Heading -->
        <?

        $collectionProducts = $collection->products;

        /*if (!\Yii::$app->shop->is_show_product_no_price)   {
            $collectionProducts = $collection->notNullProduct;
        }*/
        if ($collectionProducts) :

            $placesProps = \skeeks\cms\models\CmsContentElementProperty::find()
                ->leftJoin(\skeeks\cms\models\CmsContentProperty::tableName(). ' ccp' , 'ccp.id ='.skeeks\cms\models\CmsContentElementProperty::tableName().'.property_id')
                ->andWhere(['ccp.code'     => 'Place_in_the_Collection'])
                ->andWhere(['element_id' => \yii\helpers\ArrayHelper::map($collectionProducts,'id', 'id')])
                ->groupBy(['value_enum'])
            ;
            if ($placesProps->exists()) : ?>
                <!-- Cube Portfolio Blocks - Filter -->
                <ul id="filterControls1" class="d-block list-inline">
                    <li class="list-inline-item cbp-filter-item cbp-filter-item-active" role="button" data-filter="*">
                        <a href="#" onclick="return false;" class="btn btn-sm u-btn-outline-darkgray g-mr-10 g-mb-15">Показать все</a>
                    </li>
                    <? foreach ($placesProps->all() as $placePropId) :
                        $placeProp = \skeeks\cms\models\CmsContentPropertyEnum::findOne($placePropId->value_enum);
                        if ($placeProp) :
                            ?>

                            <li class="list-inline-item cbp-filter-item" role="button" data-filter=".id<?=$placeProp->id?>">
                                <a href="#" onclick="return false;" class="btn btn-sm u-btn-outline-darkgray g-mr-10 g-mb-15"><?=$placeProp->value;?></a>
                            </li>
                        <?  endif; ?>
                    <? endforeach; ?>
                </ul>
                <!-- End Cube Portfolio Blocks - Filter -->
            <?  endif; ?>
            <!-- Cube Portfolio Blocks - Content -->
            <div class="cbp" data-controls="#filterControls1" data-animation="quicksand" data-x-gap="30" data-y-gap="30" data-media-queries='[{"width": 1500, "cols": 4}, {"width": 1100, "cols": 4}, {"width": 800, "cols": 4}, {"width": 480, "cols": 3}, {"width": 300, "cols": 1}]'>
                <? foreach ($collectionProducts as $product) :
                    /**
                     * @var $product \skeeks\cms\shop\models\ShopCmsContentElement
                     */
                    $priceHelper = \Yii::$app->shop->cart->getProductPriceHelper($product);

                    ?>
                    <!-- Cube Portfolio Blocks - Item -->
                    <div class="col-lg-3 col-md-6 col-sm-6 item cbp-item identity <? if ($product->relatedPropertiesModel->getAttribute('Place_in_the_Collection')) : ?>id<?=$product->relatedPropertiesModel->getAttribute('Place_in_the_Collection'); ?><? endif; ?>">
                        <article class="card-prod h-100 to-cart-fly-wrapper">
                            <? if ($product->shopProduct && $product->shopProduct->baseProductPrice && $product->shopProduct->minProductPrice && $product->shopProduct->minProductPrice->id != $product->shopProduct->baseProductPrice->id) :

                                $percent = (int)($priceHelper->percent * 100); ?>
                                <div class="card-prod--sale">
                                    <div><span class="number">-<?=(int)$percent;?></span><span class="percent">%</span></div>
                                    <div class="caption">скидка</div>
                                </div>
                            <? endif; ?>
                            <div class="card-prod--photo">
                                <a href="<?= $product->url; ?>" data-pjax="0">
                                    <img class="to-cart-fly-img" src="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($product->image ? $product->image->src : null,
                                        new \skeeks\cms\components\imaging\filters\Thumbnail([
                                            'w' => 260,
                                            'h' => 200,
                                            'm' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                                        ]), $product->code
                                    ); ?>" title="<?= \yii\helpers\Html::encode($product->name); ?>" alt="<?= \yii\helpers\Html::encode($product->name); ?>" />
                                </a>
                            </div>
                            <div class="card-prod--inner">

                                <!--<div class="card-prod--reviews">
                    <?/* if ($count>0) : */?>
                        <div class="rating">
                            <div class="star <?/*= ($rating > 0) ? "active" :''*/?>"></div>
                            <div class="star <?/*= ($rating > 2) ? "active" :''*/?>"></div>
                            <div class="star <?/*= ($rating > 3) ? "active" :''*/?>"></div>
                            <div class="star <?/*= ($rating > 4) ? "active" :''*/?>"></div>
                            <div class="star <?/*= ($rating >=5 ) ? "active" :''*/?>"></div>
                        </div>
                    <?/* else : */?>
                        <div class="rating">
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                        </div>
                    <?/* endif; */?>
                    <div class="caption"><a href="<?/*=$model->url.'#tab-reviews'*/?>">(<?/*= (int) $count;*/?> отзывов)</a></div>
                </div>-->


                                <?/* if ($model->relatedPropertiesModel->getSmartAttribute('typeConstruct')) : $prop = $model->relatedPropertiesModel->getSmartAttribute('typeConstruct'); */?>
                                <!--<div class="card-prod--category">
                        <?/* if ($model->cmsTree) : */?>
                            <a href="<?/*= $model->cmsTree->url; */?>"><?/*= $model->cmsTree->name; */?></a>
                        <?/* endif; */?>
                    </div>-->
                                <?/* endif; */?>

                                <div class="card-prod--title">
                                    <a href="<?= $product->url; ?>" title="<?= $product->name; ?>" data-pjax="0" class="g-color-gray-dark-v2 g-font-weight-600 g-line-height-1"><?= $product->name; ?></a>
                                </div>
                                <? if (isset($product->shopProduct)) : ?>
                                    <div class="card-prod--price">
                                        <? if ($priceHelper->hasDiscount) : ?>
                                            <div class="old"><?= $priceHelper->basePrice->money; ?></div>
                                            <div class="new"><?= $priceHelper->minMoney; ?></div>
                                        <? else : ?>
                                            <div class="new g-color-primary g-font-size-20"><?= $priceHelper->minMoney; ?></div>
                                        <? endif; ?>

                                    </div>

                                    <div class="card-prod--actions">
                                        <? if ($product->shopProduct->quantity > 0 && $product->shopProduct->minProductPrice) : ?>
                                            <?= \yii\helpers\Html::tag('button', "<i class=\"icon cart\"></i>Купить", [
                                                'class' => 'btn btn-primary js-to-cart to-cart-fly-btn',
                                                'type' => 'button',
                                                'onclick' => new \yii\web\JsExpression("sx.Shop.addProduct({$product->shopProduct->id}, 1); return false;"),
                                            ]); ?>
                                        <? else : ?>
                                            <?= \yii\helpers\Html::tag('a', "Подробнее", [
                                                'class' => 'btn to-cart',
                                                'type' => 'button',
                                                'href' => $product->url,
                                                'data' => ['pjax' => 0],
                                            ]); ?>
                                        <? endif; ?>
                                    </div>
                                <? endif; ?>
                            </div>
                            <div class="card-prod--hidden">
                                <div class="card-prod--inner">
                                    <div class="with-icon-group">


                                        <?/* if ($model->relatedPropertiesModel->getSmartAttribute('totalDetaley')) : $prop = $model->relatedPropertiesModel->getSmartAttribute('totalDetaley'); */?><!--
                        <p class="with-icon"><img src="<?/*= \v3project\themes\mega\assets\ThemeMegaBuildAsset::getAssetUrl('images/details.png'); */?>" alt="">деталей: <?/*=$prop;*/?></p>
                        --><?/* endif; */?>
                                        <!--<p class="with-icon"><img src="<?/*= \v3project\themes\mega\assets\ThemeMegaBuildAsset::getAssetUrl('images/age.png'); */?>" alt="">возраст:
                            --><?/*= $v3ProductElement->v3toysProductProperty ? $v3ProductElement->v3toysProductProperty->ageString : ""; */?>
                                    </div>

                                    <?/* if ($v3ProductElement->v3toysProductProperty->sku) : */?><!--
                        <p>Артикул: <?/*= $v3ProductElement->v3toysProductProperty->sku; */?></p>
                    <?/* endif; */?>
                    <?/* if ($prop = $model->relatedPropertiesModel->getSmartAttribute('brand')) : */?>
                        <p>Бренд:  <?/*=$prop; */?></p>
                    --><?/* endif; */?>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!-- End Cube Portfolio Blocks - Item -->
                <? endforeach; ?>
            </div>
        <?  endif; ?>

    </div>
</section>
<!-- End Cube Portfolio Blocks - Content -->


<? if (\Yii::$app->shop->shopContents) : ?>
    <section class="g-brd-top g-mt-20 noborder">

        <?
        $treeIds = [];
        if ($model->cmsTree && $model->cmsTree->parent) {
            $treeIds = \yii\helpers\ArrayHelper::map($model->cmsTree->parent->children, 'id', 'id');
        }
        ?>
        <div class="container g-mt-20 g-mb-40 ">
            <?
            $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("product-similar-products", [
                'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-stick',
                'label'                => "Рекомендуем также",
                'enabledPaging'        => "N",
                'content_ids'          => \yii\helpers\ArrayHelper::map(\Yii::$app->shop->shopContents, 'id', 'id'),
                'tree_ids'             => $treeIds,
                'limit'                => 15,
                'contentElementClass'  => \skeeks\cms\shop\models\ShopCmsContentElement::class,
                'dataProviderCallback' => function (\yii\data\ActiveDataProvider $activeDataProvider) use ($model) {
                    $activeDataProvider->query->with('shopProduct');
                    $activeDataProvider->query->with('shopProduct.baseProductPrice');
                    $activeDataProvider->query->with('shopProduct.minProductPrice');
                    $activeDataProvider->query->with('image');
                    //$activeDataProvider->query->joinWith('shopProduct.baseProductPrice as basePrice');
                    //$activeDataProvider->query->orderBy(['show_counter' => SORT_DESC]);

                    $activeDataProvider->query->andWhere(['!=', \skeeks\cms\models\CmsContentElement::tableName().".id", $model->id]);

                },
            ]);
            $widgetElements::end();
            ?>
        </div>
    </section>
<? endif; ?>

<section class="g-brd-gray-light-v4 g-brd-top g-mt-20 g-mb-20">
    <div class="container">

        <div class="col-md-12 g-mt-20" id="sx-reviews">
            <div class="float-right"><a href="#showReviewFormBlock"  data-toggle="modal" class="btn btn-primary showReviewFormBtn">Оставить отзыв</a></div><h2>Отзывы</h2>
        </div>

        <?
        $widgetReviews = \skeeks\cms\reviews2\widgets\reviews2\Reviews2Widget::begin([
            'namespace'         => 'Reviews2Widget',
            'viewFile'          => '@app/views/widgets/Reviews2Widget/reviews',
            'cmsContentElement' => $model,
        ]);
        $widgetReviews::end();
        ?>
    </div>
</section>



<section class="g-brd-gray-light-v4 g-brd-top g-mt-20">

    <? if (\Yii::$app->shop->shopContents) : ?>
        <?
        $treeIds = [];
        if ($model->cmsTree && $model->cmsTree->parent) {
            $treeIds = \yii\helpers\ArrayHelper::map($model->cmsTree->parent->children, 'id', 'id');
        }
        ?>
        <div class="container g-mt-20 g-mb-40 ">
            <?
            $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("product-viewed-products", [
                'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-stick',
                'label'                => "Просмотренные товары",
                'enabledPaging'        => "N",
                'content_ids'          => \yii\helpers\ArrayHelper::map(\Yii::$app->shop->shopContents, 'id', 'id'),
                //'tree_ids'             => $treeIds,
                'enabledSearchParams'                => "N",
                'enabledCurrentTree'                => "N",
                'limit'                => 15,
                'contentElementClass'  => \skeeks\cms\shop\models\ShopCmsContentElement::class,
                'activeQueryCallback' => function (\yii\db\ActiveQuery $query) use ($model) {
                    $query->andWhere(['!=', \skeeks\cms\models\CmsContentElement::tableName() . ".id", $model->id]);
                    $query->leftJoin('shop_product', '`shop_product`.`id` = `cms_content_element`.`id`');
                    $query->leftJoin('shop_viewed_product', '`shop_viewed_product`.`shop_product_id` = `shop_product`.`id`');
                    $query->andWhere(['shop_user_id' => \Yii::$app->shop->shopUser->id]);
                    //$query->orderBy(['shop_viewed_product.created_at' => SORT_DESC]);
                }
            ]);
            $widgetElements::end();
            ?>
        </div>
    <? endif; ?>
</section>