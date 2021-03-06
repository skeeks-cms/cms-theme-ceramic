<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\themes\ceramic\components;

use skeeks\cms\base\Component;
use skeeks\cms\models\CmsAgent;
use skeeks\cms\models\CmsContent;
use skeeks\cms\shop\models\ShopPersonType;
use skeeks\cms\shop\models\ShopTypePrice;
use skeeks\yii2\form\fields\BoolField;
use skeeks\yii2\form\fields\FieldSet;
use skeeks\yii2\form\fields\SelectField;
use yii\helpers\ArrayHelper;
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 *
 * @property ShopTypePrice    $baseTypePrice
 * @property ShopPersonType[] $shopPersonTypes
 * @property ShopTypePrice[]  $shopTypePrices
 * @property ShopTypePrice[]  $canBuyTypePrices
 *
 *
 * @property CmsContent       $shopContents
 * @property CmsContent       $storeContent
 * @property CmsContent       $stores
 *
 * Class ShopComponent
 * @package skeeks\cms\shop\components
 */
class CeramicComponent extends Component
{
    /**
     * Показывать слайдер с популярными коллекциями на главной?
     * @var int
     */
    public $is_show_popular_collection = 1;

    /**
     * Показывать слайдер с новыми коллекциями на главной?
     * @var int
     */
    public $is_show_new_collection = 1;

    /*
     * Показывать современный каталог на главной
     */
    public $is_show_home_modern_catalog = 1;
    /*
     * Показывать обычный каталог на главной
     */
    public $is_show_home_old_catalog = 0;
    /*
     * Показывать обычный слайдер на главной
     */
    public $is_show_home_slider = 0;

    public $collection_item_view = 'v2';

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

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'is_show_popular_collection',
                    'is_show_new_collection',

                    'is_show_home_modern_catalog',
                    'is_show_home_old_catalog',
                    'is_show_home_slider',
                ],
                'boolean',
            ],
            ['collection_item_view', 'string'],
        ]);
    }

    public function getConfigFormFields()
    {
        return [
            'main' => [
                'class' => FieldSet::class,
                'name'  => \Yii::t('skeeks/shop/app', 'Main'),

                'fields' => [

                    'is_show_popular_collection'  => [
                        'class'       => BoolField::class,
                        'allowNull'   => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                    'is_show_new_collection'      => [
                        'class'       => BoolField::class,
                        'allowNull'   => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                    'is_show_home_modern_catalog' => [
                        'class'       => BoolField::class,
                        'allowNull'   => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                    'is_show_home_old_catalog'    => [
                        'class'       => BoolField::class,
                        'allowNull'   => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                    'is_show_home_slider'         => [
                        'class'       => BoolField::class,
                        'allowNull'   => false,
                        'formElement' => BoolField::ELEMENT_RADIO_LIST,
                    ],
                    'collection_item_view'        => [
                        'class' => SelectField::class,
                        'items' => [
                            'v1' => 'Вариант 1 (маленькие блоки как на tesser.ru)',
                            'v2' => 'Вариант 2 (Большие фото со всплывающей кнопкой Подробнее)',
                        ],
                    ],

                ],
            ],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
                'is_show_popular_collection' => 'Показывать слайдер с популярными коллекциями на главной?',
                'is_show_new_collection'     => 'Показывать слайдер с новыми коллекциями на главной?',
                'collection_item_view'       => "Вариант отображения коллекции",

                'is_show_home_modern_catalog' => "Показывать современный каталог на главной",
                'is_show_home_old_catalog'    => "Показывать обычный каталог на главной",
                'is_show_home_slider'         => "Показывать слайдер на главной",
            ]
        );
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
                //'is_show_popular_collection' => 'Начальный статус заказа'
            ]
        );
    }

}