<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\themes\ceramic;

use skeeks\cms\themes\unify\UnifyTheme;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CeramicTheme extends UnifyTheme
{
    /**
     * @var array
     */
    public $pathMap = [
        '@app/views' => [
            '@skeeks/cms/themes/ceramic/views',
            '@skeeks/cms/themes/unifyshop/views',
            '@skeeks/cms/themes/unify/views',
        ],
    ];


}