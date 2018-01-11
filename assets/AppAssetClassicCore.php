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
class AppAssetClassicCore extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/webAssets/templates/classic/global/';
    
    public $css = [
        "css/bootstrap.min.css",
        "css/bootstrap-extend.min.css",
        // plugins
        "vendor/animsition/animsition.css",
        "vendor/asscrollable/asScrollable.css",
        "vendor/switchery/switchery.css",
        "vendor/intro-js/introjs.css",
        "vendor/slidepanel/slidePanel.css",
        'vendor/bootstrap-sweetalert/sweetalert.css',
        "vendor/flag-icon-css/flag-icon.css",
        // Fonts
        "fonts/web-icons/web-icons.min.css",
        "fonts/brand-icons/brand-icons.min.css",
        "fonts/7-stroke/7-stroke.css",
        'fonts/font-awesome/font-awesome.css',
        'fonts/octicons/octicons.css',
        'http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic',
     
    ];
    public $js = [
        'vendor/babel-external-helpers/babel-external-helpers.js',
        #'vendor/jquery/jquery.js',
        'vendor/tether/tether.js',
        'vendor/bootstrap/bootstrap.js',
        'vendor/animsition/animsition.js',
        'vendor/mousewheel/jquery.mousewheel.js',
        'vendor/asscrollbar/jquery-asScrollbar.js',
        'vendor/asscrollable/jquery-asScrollable.js',
        'vendor/switchery/switchery.min.js',
        'vendor/intro-js/intro.js',
        'vendor/screenfull/screenfull.js',
        'vendor/slidepanel/jquery-slidePanel.js',
        'vendor/jquery-placeholder/jquery.placeholder.js',
        'vendor/bootstrap-sweetalert/sweetalert.js',
        'js/State.js',
        'js/Component.js',
        'js/Plugin.js',
        'js/Base.js',
        'js/Config.js',
        'js/config/colors.js',
        'js/Plugin/asscrollable.js',
        'js/Plugin/slidepanel.js',
        'js/Plugin/switchery.js',
        'js/Plugin/material.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
