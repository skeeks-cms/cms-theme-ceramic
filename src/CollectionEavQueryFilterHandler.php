<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\themes\ceramic;

use skeeks\cms\eavqueryfilter\CmsEavQueryFilterHandler;
use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsContentElementProperty;
use skeeks\cms\themes\ceramic\models\CeramicCollectionMap;
use skeeks\cms\themes\ceramic\models\ProductCmsContentElement;
use skeeks\cms\themes\unify\UnifyTheme;
use yii\base\Exception;
use yii\db\Expression;
use yii\db\QueryInterface;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CollectionEavQueryFilterHandler extends CmsEavQueryFilterHandler
{

    /**
     * @param $query
     * @return $this
     */
    public function initRPByQuery($query)
    {
        if ($rps = $query->all()) {
            foreach ($rps as $rp) {
                $this->_rpInit($rp);
            }
        }

        /**
         * @var $query \yii\db\ActiveQuery
         */
        $query = clone $this->baseQuery;
        $query->with = [];
        $query->select(['cms_content_element.id as mainId', 'cms_content_element.id as id'])
            ->indexBy('mainId')
        ;
        $products = [];
        if ($ids = $query->column()) {
            $ids = implode(",", $ids);
            $products = CeramicCollectionMap::find()
                //->where(['in', 'collection_id', implode(",", $ids)])
                ->andWhere(new Expression("collection_id in ({$ids})"))
                ->select(['product_id']);
        }


        $this->elementIds = $products;

        return $this;
    }



    public function applyToQuery(QueryInterface $activeQuery)
    {
        $classSearch = CmsContentElementProperty::class;
        $tableName = CmsContentElement::tableName();

        $elementIdsGlobal = [];
        $applyFilters = false;
        $unionQueries = [];

        foreach ($this->toArray() as $code => $value) {

            if ($property = $this->getRPByCode($code)) {

                if ($property->property_type == \skeeks\cms\relatedProperties\PropertyType::CODE_NUMBER) {
                    $elementIds = [];

                    $query = $classSearch::find()->select(['element_id as id'])->where([
                        "property_id" => $property->id,
                    ])->indexBy('element_id');

                    if ($fromValue = $this->{$this->getAttributeNameRangeFrom($property->id)}) {
                        $applyFilters = true;

                        $query->andWhere(['>=', 'value_num', (float)$fromValue]);
                    }

                    if ($toValue = $this->{$this->getAttributeNameRangeTo($property->id)}) {

                        $applyFilters = true;

                        $query->andWhere(['<=', 'value_num', (float)$toValue]);
                    }

                    if (!$fromValue && !$toValue) {
                        continue;
                    }

                    $unionQueries[] = $query;
                    //$elementIds = $query->all();

                } else {
                    if (!$value) {
                        continue;
                    }

                    $applyFilters = true;

                    if ($property->property_type == \skeeks\cms\relatedProperties\PropertyType::CODE_STRING) {
                        $query = $classSearch::find()->select(['element_id as id'])
                            ->where([
                                "property_id" => $property->id,
                            ])
                            ->andWhere([
                                'like',
                                'value',
                                $value,
                            ]);

                        /*->indexBy('element_id')
                        ->all();*/
                        $unionQueries[] = $query;

                    } else {
                        if ($property->property_type == \skeeks\cms\relatedProperties\PropertyType::CODE_BOOL) {
                            $query = $classSearch::find()->select(['element_id as id'])->where([
                                "value_bool"  => $value,
                                "property_id" => $property->id,
                            ]);
                            //print_r($query->createCommand()->rawSql);die;
                            //$elementIds = $query->indexBy('element_id')->all();
                            $unionQueries[] = $query;
                        } else {
                            if (in_array($property->property_type, [
                                \skeeks\cms\relatedProperties\PropertyType::CODE_ELEMENT
                                ,
                                \skeeks\cms\relatedProperties\PropertyType::CODE_LIST
                                ,
                                \skeeks\cms\relatedProperties\PropertyType::CODE_TREE,
                            ])) {
                                $query = $classSearch::find()->select(['element_id as id'])->where([
                                    "value_enum"  => $value,
                                    "property_id" => $property->id,
                                ]);
                                //print_r($query->createCommand()->rawSql);die;
                                //$elementIds = $query->indexBy('element_id')->all();
                                $unionQueries[] = $query;
                            } else {
                                $query = $classSearch::find()->select(['element_id as id'])->where([
                                    "value"       => $value,
                                    "property_id" => $property->id,
                                ]);
                                //print_r($query->createCommand()->rawSql);die;
                                //$elementIds = $query->indexBy('element_id')->all();
                                $unionQueries[] = $query;
                            }
                        }
                    }
                }


            }

        }

        if ($applyFilters) {
            if ($unionQueries) {
                /**
                 * @var $unionQuery ActiveQuery
                 */
                $lastQuery = null;
                $unionQuery = null;
                $unionQueriesStings = [];
                foreach ($unionQueries as $query) {
                    if ($lastQuery) {
                        $lastQuery->andWhere(['in', 'element_id', $query]);
                        $lastQuery = $query;
                        continue;
                    }

                    if ($unionQuery === null) {
                        $unionQuery = $query;
                    } else {
                        $unionQuery->andWhere(['in', 'element_id', $query]);
                        $lastQuery = $query;
                    }
                }
            }


            $activeQuery->joinWith("ceramicCollectionMaps as ceramicCollectionMaps");
            $activeQuery->andWhere(['in', 'ceramicCollectionMaps.product_id', $unionQuery]);

        }

        return $this;
    }

}