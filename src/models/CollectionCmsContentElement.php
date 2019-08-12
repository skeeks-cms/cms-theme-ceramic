<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property ProductCmsContentElement[] $products
 * @property ProductCmsContentElement[] $hasPriceProducts Товары которые имеют не нулевую цену
 *
 * @property ProductCmsContentElement $firstProduct Первый продукт связанной с коллекцией
 * @property ProductCmsContentElement $minPriceProduct Продукт с минимальной ценой
 *
 * @property CeramicCollectionMap[] $ceramicCollectionMaps
 *
 * @property string $country Страна
 * @property string $brand Производитель
 */
class CollectionCmsContentElement extends CmsContentElement
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(ProductCmsContentElement::className(), ['id' => 'product_id'])
            ->viaTable('ceramic_collection_map', ['collection_id' => 'id'])
            ->from(['ceramicProductContentElement' => ProductCmsContentElement::tableName()])
            ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCeramicCollectionMaps()
    {
        return $this->hasMany(CeramicCollectionMap::class, ['collection_id' => 'id']);
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
    public function getHasPriceProducts()
    {
        $query = $this->getProducts()
            ->joinWith('shopProduct.shopProductPrices as pricesFilter')
            ->andWhere(['>','`pricesFilter`.price',0]);

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
            //->limit(1)
        ;
        $query->multiple = false;
        return $query;
    }




    /**
     * @return string
     */
    public function getCountry()
    {
        if ($this->firstProduct && $this->firstProduct->relatedPropertiesModel->getAttribute('Country_of_manufacture')) {
            return  $this->firstProduct->relatedPropertiesModel->getSmartAttribute('Country_of_manufacture');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        if ($this->firstProduct && $this->firstProduct->relatedPropertiesModel->getAttribute('brand')) {
            return  $this->firstProduct->relatedPropertiesModel->getSmartAttribute('brand');
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