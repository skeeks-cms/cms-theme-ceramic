<?php
/**
 * Created by PhpStorm.
 * User: assole
 * Date: 08.08.2019
 * Time: 10:11
 */
namespace skeeks\cms\themes\ceramic\console\controllers;
use common\models\CeramicCollectionMap;
use skeeks\cms\models\CmsContentElement;

/**
 * Class OnceController
 * @package console\controllers
 */
class CollectionController extends \yii\console\Controller
{
    /**
     * Сортировка товаров по коллекциям
     */
    public function actionUpdateMap()
    {
        $products = CmsContentElement::find()->andWhere(['type' => 2]);
        foreach ($products->each(50) as $product) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $collectionID = $product->relatedPropertiesModel->getAttribute('Category');
                $connection = CeramicCollectionMap::find()->andWhere(['product_id'=>$product->id])->andWhere(['collection_id' => $collectionID]);
                if (!$connection->exists()) {
                    $connection = new CeramicCollectionMap();
                    $connection->product_id = $product->id;
                    $connection->collection_id = $collectionID;

                    if (!$connection->save()) {
                        throw new Exception($cmsNewMainDomain->errors);
                    }
                }
                    $transaction->commit();
            }
            catch (\Throwable $e) {
                $transaction->rollBack();
                \Yii::error('Связь для товара не установилась ' . $e->getMessage(), self::class);
            }
        }

    }
}