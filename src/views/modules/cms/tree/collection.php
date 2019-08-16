<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsTree */
$this->registerCss(<<<CSS
.g-parent {
    text-align: center;
}
CSS
);
?>
<? if ($this->theme->is_image_body_begin) : ?>
    <section class="g-bg-cover g-bg-size-cover g-bg-white-gradient-opacity-v1--after sx-body-begin-image-wrapper" data-bg-img-src="<?= $model->image ? $model->image->src : $this->theme->body_begin_no_image; ?>" style="background-image: url('<?= $model->image ? $model->image->src : $this->theme->body_begin_no_image; ?>'); background: center;">
        <div class="container text-center g-pos-rel g-z-index-1 g-pb-50">
            <div class="row d-flex justify-content-center align-content-end flex-wrap g-min-height-<?= $this->theme->body_begin_image_height_tree; ?>">
                <div class="col-lg-10 mt-auto">
                    <div class="mb-5">
                        <div class="lead g-color-white-opacity-0_8"><?= $this->render('@app/views/breadcrumbs', [
                                'model'    => $model,
                                'isShowH1' => false,
                            ]) ?>
                        </div>
                        <h1 class="g-color-white g-font-weight-600 g-mb-30"><?= $model->name; ?></h1>
                        <div class="lead g-color-white-opacity-0_8"><?= $model->description_short; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? endif; ?>

<section class="g-mt-0 g-pb-0">
    <div class="container g-bg-white">
        <div class="row">
            <? if ($this->theme->tree_content_layout == 'col-left') : ?>
            <div class="col-md-9 order-md-2 g-py-20">
                <? endif; ?>
                <? if ($this->theme->tree_content_layout == 'col-right') : ?>
                <div class="col-md-9 g-py-20">
                    <? endif; ?>
                    <? if ($this->theme->tree_content_layout == 'no-col') : ?>
                    <div class="col-md-12 g-py-20">
                        <? endif; ?>
                        <? if ($this->theme->tree_content_layout == 'col-left-right') : ?>
                        <div class="col-md-7  order-md-2 g-py-20">
                            <? endif; ?>

                            <? if (!$this->theme->is_image_body_begin) : ?>
                                <?= $this->render('@app/views/breadcrumbs', [
                                    'model' => $model,
                                ]); ?>
                            <? endif; ?>

                            <div class="g-color-gray-dark-v1 g-font-size-16 sx-content">
                                <?= $model->description_full; ?>
                            </div>

                            <!-- Cube Portfolio Blocks - Content -->
                            <div id="portfolio-section">
                                <!-- Heading -->
                                <?
                                $filtersWidget = \skeeks\cms\themes\unify\widgets\filters\FiltersWidget::begin();

                                $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("collections", [
                                    'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-collections',
                                    'enabledPaging'        => "Y",
                                    'pageSize'             => 30,
                                    'orderBy'              => 'name',
                                    'order'                => SORT_ASC,
                                    'contentElementClass'  => \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::class,
                                    'dataProviderCallback' => function (\yii\data\ActiveDataProvider $activeDataProvider) use ($model) {


                                        /**
                                         * @var $query \yii\db\ActiveQuery
                                         */
                                        $query = $activeDataProvider->query;
                                        $query
                                            ->select([
                                                \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName().".*",
                                            ])
                                            ->joinWith('products as p');

                                        $query->andWhere(['IS NOT', 'p.id', null]);
                                        $query->andWhere(['IS NOT', \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName().'.image_id', null]);
/*
                                        if (!\Yii::$app->shop->is_show_product_no_price) {
                                            $query->joinWith('p.shopProduct.shopProductPrices as pricesFilter')
                                                ->andWhere(['>','`pricesFilter`.price',0]);
                                        }*/


                                    },
                                ]);

                                $query = $widgetElements->dataProvider->query;
                                $baseQuery = clone $query;


                                $eavFiltersHandler = new \skeeks\cms\themes\ceramic\CollectionEavQueryFilterHandler([
                                    'baseQuery' => $baseQuery,
                                ]);
                                $eavFiltersHandler->viewFile = '@app/views/filters/eav-filters';
                                $rpQuery = $eavFiltersHandler->getRPQuery();

                                if (\Yii::$app->shop->show_filter_property_ids) {
                                    $rpQuery->andWhere([\skeeks\cms\models\CmsContentProperty::tableName().'.id' => \Yii::$app->shop->show_filter_property_ids]);
                                }
                                /*$rpQuery->andWhere([
                                    'cmap.cms_content_id' => $model->tree_id,
                                ]);*/
                                /*$rpQuery->andWhere(
                                    ['map.cms_tree_id' => $model->id]
                                );*/
                                $eavFiltersHandler->initRPByQuery($rpQuery);

                                $filtersWidget
                                    ->registerHandler($eavFiltersHandler);


                                $filtersWidget->loadFromRequest();
                                $filtersWidget->applyToQuery($query);

                                $widgetElements::end();
                                ?>

                            </div>
                            <!-- End Cube Portfolio Blocks - Content -->


                            <? if ($model->images) : ?>
                                <?= $this->render("@app/views/include/gallery", ['images' => $model->images]); ?>
                            <? endif; ?>
                            <?= $this->render("@app/views/include/bottom-block"); ?>
                        </div>


                        <div class="col-md-3 order-md-1 g-py-20 g-bg-secondary">
                            <div class="g-mb-20">
                                <? $filtersWidget::end(); ?>
                                <div id="stickyblock-start" class="g-pa-5 js-sticky-block" data-start-point="#stickyblock-start" data-end-point=".sx-footer">

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
</section>
