<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property ProductCmsContentElement[] $cmsContentElementProducts
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
}
