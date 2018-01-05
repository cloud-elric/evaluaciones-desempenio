<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/webAssets/';
    public $css = [
        'plugins/ladda/ladda.css',
        'css/site-extend.css'
    ];
    public $js = [
        'plugins/ladda/spin.js',
        'plugins/ladda/ladda.js',
        'js/geeks.js'

    ];
    public $depends = [
        'app\assets\AppAssetClassicTopBar',
    ];
}
