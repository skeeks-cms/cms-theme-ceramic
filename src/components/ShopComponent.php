<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\themes\ceramic\components;

use skeeks\cms\base\Component;
use skeeks\cms\components\Cms;
use skeeks\cms\models\CmsAgent;
use skeeks\cms\models\CmsContent;
use skeeks\cms\models\CmsContentProperty;
use skeeks\cms\models\CmsUser;
use skeeks\cms\shop\models\ShopCart;
use skeeks\cms\shop\models\ShopOrderStatus;
use skeeks\cms\shop\models\ShopPersonType;
use skeeks\cms\shop\models\ShopTypePrice;
use skeeks\yii2\form\fields\BoolField;
use skeeks\yii2\form\fields\FieldSet;
use skeeks\yii2\form\fields\HtmlBlock;
use skeeks\yii2\form\fields\SelectField;
use skeeks\yii2\form\fields\TextareaField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 *
 * @property ShopTypePrice    $baseTypePrice
 * @property ShopPersonType[] $shopPersonTypes
 * @property ShopTypePrice[]  $shopTypePrices
 * @property ShopTypePrice[]  $canBuyTypePrices
 *
 * @property ShopCart         $cart
 *
 * @property CmsContent       $shopContents
 * @property CmsContent       $storeContent
 * @property CmsContent       $stores
 *
 * @property array            $notifyEmails
 *
 * Class ShopComponent
 * @package skeeks\cms\shop\components
 */
class ShopComponent extends Component
{
    /**
     * Показывать у товаров оставшееся количество на складе? Актуально для агрегаторов
     * @var int
     */
    public $is_show_quantity_product = 1;

    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Настройки каталога для магазина керамики',
        ]);
    }

    public function getConfigFormFields()
    {
        return [
            'main' => [
                'class' => FieldSet::class,
                'name' => \Yii::t('skeeks/shop/app', 'Каталог'),
                'fields' => [
                    'is_show_quantity_product' => [
                        'class' => BoolField::class,
                        'allowNull' => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                ]
            ]
        ];
    }
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'is_show_quantity_product',
                ],
                'boolean',
            ],
        ]);
    }
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'is_show_quantity_product'  => "Показывать оставшееся количество товаров на складе?",
        ]);
    }
    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'is_show_quantity_product' => "Актуально для агрегаторов, когда товары поставляются под заказ",
        ]);
    }

}