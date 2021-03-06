<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.08.2015
 */
return [

    'components' => [
        'ceramic'   =>  [
            'class' => 'skeeks\cms\themes\ceramic\components\CeramicComponent',
        ],

        'cmsAgent' => [
            'commands' => [

                'ceramic/collection/update-map' => [
                    'class'    => \skeeks\cms\agent\CmsAgent::class,
                    'name'     => 'Сортировка товаров по коллекциям',
                    'interval' => 3600 * 6,
                ],
                'cms/image/resize-original-images' => [
                    'class'    => \skeeks\cms\agent\CmsAgent::class,
                    'name'     => 'Оптимизация картинок',
                    'interval' => 3600 * 24,
                ],
            ],
        ],

    ],

    'modules' => [
        'ceramic' => [
            'class' => 'skeeks\cms\themes\ceramic\CeramicModule',
        ],
    ],
];