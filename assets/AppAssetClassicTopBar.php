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
class AppAssetClassicTopBar extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/webAssets/templates/classic/topbar/assets/';
    public $css = [
      'css/site.min.css',
    ];
    public $js = [
        'js/Section/Menubar.js',
        'js/Section/Sidebar.js',
        'js/Section/PageAside.js',
        'js/Plugin/menu.js',
        'js/config/tour.js',
        '../../global/js/ConfigInit.js',
        '../../global/js/Plugin/bootstrap-sweetalert.js',
        'js/Site.js',
    ];
    public $depends = [
        'app\assets\AppAssetClassicCore',
    ];
}
