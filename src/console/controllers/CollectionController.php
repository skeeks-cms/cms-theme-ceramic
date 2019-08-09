<?php
/**
 * Created by PhpStorm.
 * User: assole
 * Date: 08.08.2019
 * Time: 10:11
 */

namespace skeeks\cms\themes\ceramic\console\controllers;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\themes\ceramic\models\CeramicCollectionMap;
use yii\base\Exception;
use yii\helpers\Console;

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
        //Товары
        $products = CmsContentElement::find()->andWhere(['content_id' => 2]);
        foreach ($products->each(50) as $product) {
            $collectionID = $product->relatedPropertiesModel->getAttribute($this->productProperty);
            if (!$collectionID) {
                continue;
            }

            $collectionIDs = explode(', ', $collectionID);

            $this->stdout("Product: {$product->id}\n");
            $this->stdout("Коллекций в товаре: {$collectionID}\n");

            foreach ($collectionIDs as $collectionID) {
                $this->stdout("\tКоллекция: {$collectionID}\n");

                $collection = CmsContentElement::find()
                    ->joinWith('relatedElementProperties map')
                    ->joinWith('relatedElementProperties.property property')
                    ->andWhere(['property.code' => $this->collectionProperty])
                    ->andWhere(['map.value' => (int)$collectionID])
                    ->one();
                
                if (!$collection) {
                    $this->stdout("\tКоллекция не найдена в нашей базе\n", Console::FG_RED);
                    die;
                }

                $connection = CeramicCollectionMap::find()
                    ->andWhere(['product_id' => $product->id])->andWhere(['collection_id' => $collection->id]);

                if (!$connection->exists()) {
                    $this->stdout("\tСвязь не создана\n");
                    try {
                        $connection = new CeramicCollectionMap();
                        $connection->product_id = $product->id;
                        $connection->collection_id = $collection->id;

                        if (!$connection->save()) {
                            throw new Exception(print_r($connection->errors, true));
                        }

                        $this->stdout("\tСвязь создана\n", Console::FG_GREEN);

                    } catch (\Exception $e) {
                        \Yii::error('Связь для товара не установилась '.$e->getMessage(), self::class);
                        $this->stdout("\tСвязь для товара не установилась {$e->getMessage()}\n", Console::FG_RED);
                        die;
                    }
                } else {
                    $this->stdout("\tСвязь уже создана\n", Console::FG_YELLOW);
                }
            }

            $this->stdout("Product: {$product->id}\n");
            if (count($collectionIDs) != CeramicCollectionMap::find()->andWhere(['product_id' => $product->id])->count()) {
                $this->stdout("Ошибка данных!\n", Console::FG_RED);
            }
            //CeramicCollectionMap::find()->andWhere(['product_id'=>$product->id])->andWhere(['collection_id' => $collection->id]);
        }

    }
}