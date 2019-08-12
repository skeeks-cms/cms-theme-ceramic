<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.08.2015
 */
return [

    'components' => [
        'i18n' => [
            'translations' =>
                [
                    'skeeks/cms/theme/ceramic/app' =>
                        [
                            'class'    => 'yii\i18n\PhpMessageSource',
                            'basePath' => '@skeeks/cms/theme/ceramic/messages',
                            'fileMap'  => [
                                'skeeks/cms/theme/ceramic/app' => 'app.php',
                            ],
                        ],
                ],
        ],

        'cmsAgent' => [
            'commands' => [

                'ceramic/collection/update-map' => [
                    'class'    => \skeeks\cms\agent\CmsAgent::class,
                    'name'     => ['skeeks/cms/theme/ceramic/app', 'Sort products by collection'],
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