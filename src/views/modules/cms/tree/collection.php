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
                                'model' => $model,
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
                            <div id="portfolio-section" class="container">
                                <!-- Heading -->
                                <?
                                $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("collections-products", [
                                    'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-collections',
                                    'enabledPaging'        => "Y",
                                    'pageSize'             => 30,
                                    'orderBy'              => 'name',
                                    'order'                => SORT_ASC,
                                    'contentElementClass'  => \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::class,
                                    'dataProviderCallback' => function (\yii\data\ActiveDataProvider $activeDataProvider) use ($model) {
                                    if (ENV == 'dev') {


                                        /**
                                         * @var $query \yii\db\ActiveQuery
                                         */
                                        $query = $activeDataProvider->query;
                                        $query
                                            ->select([
                                                \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName() . ".*",
                                            ])
                                            ->joinWith('products as p')
                                            /*->joinWith('productCmsContentElements.shopProduct as shopProduct')
                                            ->joinWith('productCmsContentElements.shopProduct.baseProductPrice as baseProductPrice')
                                            ->andWhere([">", "baseProductPrice.price", 0])*/
                                        ;

                                        $query->andWhere(['IS NOT', 'p.id', null]);
                                        $query->andWhere(['IS NOT', \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName() . '.image_id', NULL]);
                                        
                                        $query->joinWith('minPriceProduct');
                                        $query->joinWith('minPriceProduct.shopProduct');
                                        $query->joinWith('minPriceProduct.shopProduct.baseProductPrice as baseProductPrice');
                                        $query->orderBy(['baseProductPrice.price' => SORT_DESC]);

                                        /*print_r($query->one());die;*/

                                        //$activeDataProvider->query->orderBy([\skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName() . ".id"]);
                                            
                                        /*$activeDataProvider->query
                                            ->andWhere(['IS NOT', 'p.id', null]);*/

                                        //var_dump($activeDataProvider->query->createCommand()->rawSql);die();
                                    }
                                        //$activeDataProvider->query->andWhere(['IS NOT', 'image_id', NULL]);
                                        //$activeDataProvider->query->andWhere(['']);
                                    }
                                ]);
                                $widgetElements::end();
                                ?>

                            </div>
                            <!-- End Cube Portfolio Blocks - Content -->

                            <?
                            $contentFaq = \skeeks\cms\models\CmsContent::find()->where(['code' => 'faq'])->one();
                            ?>
                            <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                                'namespace' => 'ContentElementsCmsWidget-faq',
                                'enabledRunCache' => \skeeks\cms\components\Cms::BOOL_N,
                                'content_ids' => [
                                    $contentFaq ? $contentFaq->id : ""
                                ],
                                'viewFile'  => '@app/views/widgets/ContentElementsCmsWidget/faq',
                            ]); ?>


                            <?= trim(\skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget::widget([
                                'namespace'       => 'TreeMenuCmsWidget-sub-catalog',
                                'viewFile'        => '@app/views/widgets/TreeMenuCmsWidget/sub-catalog',
                                'treePid'         => $model->id,
                                'enabledRunCache' => \skeeks\cms\components\Cms::BOOL_N,
                            ])); ?>

                            <?
                            $contentNews = \skeeks\cms\models\CmsContent::find()->where(['code' => 'news'])->one();
                            ?>
                            <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                                'namespace' => 'news',
                                'content_ids' => [
                                    $contentNews ? $contentNews->id : ""
                                ],
                                'viewFile'  => '@app/views/widgets/ContentElementsCmsWidget/' . $this->theme->news_list_view,
                            ]); ?>

                            <?
                            $contentNews = \skeeks\cms\models\CmsContent::find()->where(['code' => 'gallery'])->one();
                            ?>
                            <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                                'namespace' => 'gallery',
                                'content_ids' => [
                                    $contentNews ? $contentNews->id : ""
                                ],
                                'viewFile'  => '@app/views/widgets/ContentElementsCmsWidget/gallery',
                            ]); ?>

                            <?
                            $contentNews = \skeeks\cms\models\CmsContent::find()->where(['code' => 'review'])->one();
                            ?>
                            <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                                'namespace' => 'review',
                                'content_ids' => [
                                    $contentNews ? $contentNews->id : ""
                                ],
                                'viewFile'  => '@app/views/widgets/ContentElementsCmsWidget/review',
                            ]); ?>

                            <? if ($model->images) : ?>
                                <?= $this->render("@app/views/include/gallery", ['images' => $model->images]); ?>
                            <? endif; ?>
                            <?= $this->render("@app/views/include/bottom-block"); ?>
                        </div>


                        <? if ($this->theme->tree_content_layout == 'col-left') : ?>
                            <?= $this->render("@app/views/include/col-left"); ?>
                        <? endif; ?>
                        <? if ($this->theme->tree_content_layout == 'col-right') : ?>
                            <?= $this->render("@app/views/include/col-left"); ?>
                        <? endif; ?>
                        <? if ($this->theme->tree_content_layout == 'no-col') : ?>

                        <? endif; ?>
                        <? if ($this->theme->tree_content_layout == 'col-left-right') : ?>
                            <?= $this->render("@app/views/include/col-left"); ?>
                        <? endif; ?>


                    </div>
                </div>
</section>
