<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property ProductCmsContentElement[] $products
 *
 * @property ProductCmsContentElement $firstProduct Первый продукт связанной с коллекцией
 * @property ProductCmsContentElement $minPriceProduct Продукт с минимальной ценой
 *
 * @property string $country Страна
 */
class CollectionCmsContentElement extends CmsContentElement
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(ProductCmsContentElement::className(), ['id' => 'product_id'])->viaTable('ceramic_collection_map', ['collection_id' => 'id'])->from(['ceramicPorductContentElement' => ProductCmsContentElement::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirstProduct()
    {
        $query = $this->getProducts()->limit(1)->orderBy(['id' => SORT_ASC]);
        $query->multiple = false;
        
        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMinPriceProduct()
    {
        $query = $this->getProducts()
            ->joinWith('shopProduct as shopProduct')
            ->joinWith('shopProduct.baseProductPrice as baseProductPrice')
            ->andWhere(['>', 'baseProductPrice.price', 0])
            ->orderBy(['baseProductPrice.price' => SORT_ASC])
            ->limit(1)
        ;
        $query->multiple = false;

        return $query;
    }


    /**
     * @return string
     */
    public function getCountry()
    {
        if ($this->firstProduct && $this->firstProduct->relatedPropertiesModel->getAttribute('country')) {
            return  $this->firstProduct->relatedPropertiesModel->getSmartAttribute('country');
        }

        return '';
    }

    public function getPrice()
    {

    }


    /**
     * Отсортируем список товаров по ценам и отдаем товар с минимальной ценой.
     * @return mixed
     */
    public function getMinCollectionPrice()
    {

        /*$priceValues =[];
        if ($this->cmsContentElementProducts) {
            foreach ($this->cmsContentElementProducts as $product) {
                $priceValues[$product->id]['price']   = $product->shopProduct->minProductPrice->price;
                $priceValues[$product->id]['model']   = $product->shopProduct;
            }
            ArrayHelper::multisort($priceValues, 'price');
            return $priceValues[0]['model'];
        }*/
    }
    
    
    public function getShopProductPrices()
    {
        /*$this->getProductCmsContentElements()
            ->joinWith('shopProduct as shopProduct')
            ->joinWith('shopProduct.minProductPrice as minProductPrice')
            ;*/
            
    }
}
