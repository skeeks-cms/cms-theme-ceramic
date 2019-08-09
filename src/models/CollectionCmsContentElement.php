<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property ProductCmsContentElement[] $cmsContentElementProducts
 * @property CmsContentElement $oneProductCollection
 * @property string $сollectionCountry
 */
class CollectionCmsContentElement extends CmsContentElement
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsContentElementProducts()
    {
        return $this->hasMany(ProductCmsContentElement::className(), ['id' => 'product_id'])->viaTable('ceramic_collection_map', ['collection_id' => 'id']);
    }

    public function getOneProductCollection()
    {
        if ($this->cmsContentElementProducts) {
            return $this->cmsContentElementProducts[0];
        }
        else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getCollectionCountry()
    {
        if ($this->oneProductCollection && $this->oneProductCollection->relatedPropertiesModel->getAttribute('country')) {
            return  $this->oneProductCollection->relatedPropertiesModel->getSmartAttribute('country');
        }
        else {
            return '';
        }
    }

    /**
     * Отсортируем список товаров по ценам и отдаем товар с минимальной ценой.
     * @return mixed
     */
    public function getMinCollectionPrice()
    {

        $priceValues =[];
        if ($this->cmsContentElementProducts) {
            foreach ($this->cmsContentElementProducts as $product) {
                $priceValues[$product->id]['price']   = $product->shopProduct->minProductPrice->price;
                $priceValues[$product->id]['model']   = $product->shopProduct;
            }
            ArrayHelper::multisort($priceValues, 'price');
            return $priceValues[0]['model'];
        }
    }
}
