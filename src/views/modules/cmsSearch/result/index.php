<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
?>

<? /*= $this->render('@template/include/breadcrumbs', [
    'title' => "Результаты поиска: " . \Yii::$app->cmsSearch->searchQuery
])*/ ?>
<section style="padding: 40px 0;">
    <div class="container sx-content">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    Вы искали: <strong><?= \Yii::$app->cmsSearch->searchQuery; ?></strong>
                </div>
                <!--=== Content Part ===-->
                <div class="row">
                    <div class="col-md-12">
                        <?

                        $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("collections", [
                            'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-collections',
                            'enabledPaging'        => "Y",
                            'pageSize'             => 30,
                            'orderBy'              => 'name',
                            'order'                => SORT_ASC,
                            'contentElementClass'  => \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::class,
                            'dataProviderCallback' => function (\yii\data\ActiveDataProvider $activeDataProvider) {


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

                                $query->andWhere(['LIKE', \skeeks\cms\themes\ceramic\models\CollectionCmsContentElement::tableName() . '.name', \Yii::$app->cmsSearch->searchQuery]);


                            },
                        ]);

                        $query = $widgetElements->dataProvider->query; ?>
                        <? if ($query->exists()) : ?>
                            <div class="text-center">
                                <h2>По вашему запросу найдены коллекции:</h2>
                            </div>
                        <? endif; ?>
                        <?
                            $widgetElements::end();
                        ?>

                        <?

                        $widgetElements = \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::beginWidget("shop-product-list", [
                            'viewFile'             => '@app/views/widgets/ContentElementsCmsWidget/products-list',
                            'pageSize'             => 15,
                            'contentElementClass'  => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
                            'dataProviderCallback' => function (\yii\data\ActiveDataProvider $activeDataProvider)
                            {
                                //$activeDataProvider->query->with('relatedProperties');

                                $activeDataProvider->query->with('shopProduct');
                                $activeDataProvider->query->with('shopProduct.baseProductPrice');
                                $activeDataProvider->query->with('shopProduct.minProductPrice');
                                $activeDataProvider->query->with('image');

                                $activeDataProvider->query->joinWith('shopProduct sProduct');
                                $activeDataProvider->query->andWhere([
                                    '!=',
                                    'sProduct.product_type',
                                    \skeeks\cms\shop\models\ShopProduct::TYPE_OFFER,
                                ]);
                                $activeDataProvider->query->where(['OR', ['LIKE', \skeeks\cms\shop\models\ShopCmsContentElement::tableName() . '.name', \Yii::$app->cmsSearch->searchQuery],['LIKE',\skeeks\cms\shop\models\ShopCmsContentElement::tableName() . '.description_short', \Yii::$app->cmsSearch->searchQuery],['LIKE',\skeeks\cms\shop\models\ShopCmsContentElement::tableName() . '.description_full', \Yii::$app->cmsSearch->searchQuery]]);
                            },

                        ]);

                        $query = $widgetElements->dataProvider->query;

                        ?>
                        <? if ($query->exists()) : ?>
                            <div class="text-center">
                                <h2>По вашему запросу найдены товары:</h2>
                            </div>
                        <? endif; ?>

                        <? $widgetElements::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
