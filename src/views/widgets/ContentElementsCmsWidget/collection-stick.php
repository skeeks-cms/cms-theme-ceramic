<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */
$query = $widget->dataProvider->query;

?>
<? if ($query->count()) : ?>

    <? if ($widget->label) : ?>
        <div class="text-center mx-auto g-max-width-600 g-mb-20">
            <h2 class="g-color-gray-dark-v2 mb-4"><?= $widget->label; ?></h2>
            <!--<p class="lead">We want to create a range of beautiful, practical and modern outerwear that doesn't cost the earth – but let's you still live life in style.</p>-->
        </div>
    <? endif; ?>

    <? echo \yii\widgets\ListView::widget([
        'dataProvider' => $widget->dataProvider,
        'itemView'     => 'collection-block-item-'.  \Yii::$app->ceramic->collection_item_view,
        'emptyText'    => '',
        'options'      => [
            'class' => 'js-carousel g-pb-0 g-mx-minus-10',
            'tag'   => 'div',
            'data'  => [
                'slidesToShow' => 4,
                'responsive' =>  [
                    [
                        'breakpoint' => 2600,
                        'settings'     => [
                            'slidesToShow' => 4,
                        ]
                    ],
                    [
                        'breakpoint' => 1025,
                        'settings'     => [
                            'slidesToShow' => 3,
                        ]
                    ],
                    [
                        'breakpoint' => 786,
                        'settings'     => [
                            'slidesToShow' => 2,
                        ]
                    ],
                    [
                        'breakpoint' => 480,
                        'settings'     => [
                            'slidesToShow' => 1,
                        ]
                    ]

                ],

                'arrows-classes'      => "u-arrow-v1 g-absolute-centered--y g-width-45 g-height-45 g-font-size-30 g-color-gray-dark-v5 g-color-primary--hover rounded-circle",
                'arrow-left-classes'  => "fa fa-angle-left g-left-0",
                'arrow-right-classes' => "fa fa-angle-right g-right-0",
            ],
        ],
        'itemOptions'  => [
            'tag' => 'div',
            'class' =>  'g-px-10'
        ],
        'layout'       => '{items}',
    ]) ?>

<? endif; ?>