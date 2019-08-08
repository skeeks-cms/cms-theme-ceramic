<?php
/**
 * Created by PhpStorm.
 * User: assole
 * Date: 08.08.2019
 * Time: 10:11
 */
namespace skeeks\cms\themes\ceramic\console\controllers;
use skeeks\cms\themes\ceramic\models\CeramicCollectionMap;
use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsContentElementProperty;

/**
 * Class OnceController
 * @package console\controllers
 */
class CollectionController extends \yii\console\Controller
{
    public $collectionProperty = 'bauservice_collection_id';
    public $productProperty = 'Collection_Id';
    /**
     * Сортировка товаров по коллекциям
     */
    public function actionUpdateMap()
    {
        $products = CmsContentElement::find()->andWhere(['content_id' => 2]);
        foreach ($products->each(50) as $product) {
            $collectionID = $product->relatedPropertiesModel->getAttribute($this->productProperty);
            if (!$collectionID) {
                continue;
            }
            $collectionIDs = explode(', ', $collectionID);
            foreach ($collectionIDs as $collectionID) {
                $collection = CmsContentElement::find()
                    ->joinWith('relatedElementProperties map')
                    ->joinWith('relatedElementProperties.property property')
                    ->andWhere(['property.code'     => $this->collectionProperty])
                    ->andWhere(['map.value'         => (int) $collectionID])
                    ->one();

                $connection = CeramicCollectionMap::find()
                    ->andWhere(['product_id'=>$product->id])->andWhere(['collection_id' => $collection->id]);
                if (!$connection->exists()) {
                    try {
                        $connection = new CeramicCollectionMap();
                        $connection->product_id = $product->id;
                        $connection->collection_id = $collection->id;

                        if (!$connection->save()) {
                            throw new Exception($connection->errors);
                        }

                    }
                    catch (\Throwable $e) {
                        \Yii::error('Связь для товара не установилась ' . $e->getMessage(), self::class);
                    }
                }
            }
        }

    }
}