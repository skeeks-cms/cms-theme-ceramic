<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.08.2015
 */
return [

    'components' => [

        'cmsAgent' => [
            'commands' => [

                'ceramic/collection/update-map' => [
                    'class'    => \skeeks\cms\agent\CmsAgent::class,
                    'name'     => ['skeeks/t/app', 'Sort products by collection'],
                    'interval' => 3600 * 6,
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