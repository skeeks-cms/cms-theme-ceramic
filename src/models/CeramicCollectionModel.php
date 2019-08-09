<?php

namespace skeeks\cms\themes\ceramic\models;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsUser;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%ceramic_collection_map}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $collection_id
 * @property integer $product_id
 *
 * @property CmsContentElement $collection
 * @property CmsContentElement $product
 */
class CeramicCollectionMap extends \skeeks\cms\models\Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ceramic_collection_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'collection_id', 'product_id'], 'integer'],
            [['collection_id', 'product_id'], 'required'],
            [['collection_id', 'product_id'], 'unique', 'targetAttribute' => ['collection_id', 'product_id'], 'message' => 'The combination of Collection ID and Product ID has already been taken.'],

            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'collection_id' => Yii::t('app', 'Collection ID'),
            'product_id' => Yii::t('app', 'Product ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(CmsContentElement::className(), ['id' => 'collection_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(CmsContentElement::className(), ['id' => 'product_id']);
    }

}
