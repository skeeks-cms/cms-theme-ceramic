<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use skeeks\cms\shop\models\ShopCmsContentElement;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property CollectionCmsContentElement[] $cmsContentElementCollections
 */
class ProductCmsContentElement extends ShopCmsContentElement
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsContentElementCollections()
    {
        return $this->hasMany(CollectionCmsContentElement::className(), ['id' => 'collection_id'])->viaTable('ceramic_collection_map', ['product_id' => 'id']);
    }
}
